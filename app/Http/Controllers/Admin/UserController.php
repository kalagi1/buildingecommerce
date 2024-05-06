<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\AwaitingCalled;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Role;
use App\Models\User;
use App\Models\Chat;
use App\Models\City;
use App\Models\Housing;
use App\Models\Project;
use App\Models\RoleChanges;
use App\Models\TaxOffice;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Town;
use Illuminate\Support\Facades\URL;
use App\Services\SmsService;


class UserController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('uploads'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function messages()
    {
        $chats = Chat::with("messages", "user")->get();
        return view("admin.chat.index", compact("chats"));
    }

    public function blockUser(Request $request, User $user)
    {
        $blockReason = $request->input('blockReason');

        if ($user->is_blocked) {
            $user->update(['is_blocked' => false]);
            return redirect()->back()->with('success', 'Kullanıcı engellemesi kaldırıldı.');
        } else {
            $user->update(['is_blocked' => true]);

            foreach ($user->projects as $value) {
                $value->update([
                    "status" => 0,
                ]);
            }

            // Send email to the offerer
            $message = 'Hesabınız erişime kapatıldı';
            $response = 'Sayın ' . $user->name . ', ' . '<br>' . $blockReason;

            Mail::to($user->email)->send(new CustomMail($message, $response));
            return redirect()->back()->with('success', 'Kullanıcı engellendi.');
        }
    }

    public function orders(Request $request)
    {
        $brands = User::where("type", "2")->where("status", "1")->where("corporate_account_status", "1")->orderBy("order", "asc")->get();
        return view('admin.users.orders', compact('brands'));
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->input('orders') as $key => $order) {
            User::where('id', $order['id'])->update(['order' => $key + 1]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function index(Request $request)
    {
        $query = User::with("role");

        if ($request->input('name') !== null) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->input('role') !== null) {
            $query->where('type', 'like', '%' . $request->input('role') . '%');
        }

        if ($request->input('email') !== null) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        $users = $query->orderByDesc('created_at')->get();

        if ($request->ajax()) {
            return view('admin.users.table', compact('users'));
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where("parent_id", "4")->get();
        return view('admin.users.create', compact("roles"));
    }
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'İsim alanı zorunludur.',
            'name.string' => 'İsim alanı metin türünde olmalıdır.',
            'name.max' => 'İsim alanı en fazla 255 karakter olmalıdır.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 3 karakterden oluşmalıdır.',
            'type.required' => 'Tip alanı zorunludur.',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'type' => 'required',
        ];

        $validatedData = $request->validate($rules, $messages);
        $mainUser = User::where('id', auth()->user()->parent_id ?? auth()->user()->id)->with('plan')->first();
        $countUser = UserPlan::where('user_id', $mainUser->id)->first();
        $users = User::where('parent_id', auth()->user()->parent_id ?? auth()->user()->id)->get();
        $userCount = User::all();
        $lastUser = User::latest()->first();

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->profile_image = 'indir.png';
        $user->password = bcrypt($validatedData['password']);
        // Şifreyi şifreleyin
        $user->type = $validatedData['type'];
        $user->status = $request->has('is_active') ? 1 : 5;
        $user->corporate_account_status = 1;
        $user->parent_id = (auth()->user()->parent_id ?? auth()->user()->id) != 3 ? (auth()->user()->parent_id ?? auth()->user()->id) : null;
        $user->code = $lastUser->id + auth()->user()->id  + 1000000;
        $user->subscription_plan_id = $mainUser->subscription_plan_id;

        $user->save();

        if ($user->save()) {
            $countUser->user_limit = $countUser->user_limit - 1;
            $countUser->save();
        }

        Chat::create([
            'user_id' => $user->id
        ]);

        session()->flash('success', 'Kullanıcı başarıyla oluşturuldu.');

        return redirect()->route('admin.users.index');
    }

    public function getTaxDocument(User $user)
    {
        $tax_document = $user->tax_document;

        if (is_null($tax_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$tax_document}"));
        preg_match('@\.(\w+)$@', $tax_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function getRecordDocument(User $user)
    {
        $record_document = $user->record_document;

        if (is_null($record_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$record_document}"));
        preg_match('@\.(\w+)$@', $record_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function getIdentityDocument(User $user)
    {
        $identity_document = $user->identity_document;

        if (is_null($identity_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$identity_document}"));
        preg_match('@\.(\w+)$@', $identity_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function getCompanyDocument(User $user)
    {
        $company_document = $user->company_document;

        if (is_null($company_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$company_document}"));
        preg_match('@\.(\w+)$@', $company_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

    public function updateCorporateStatus(Request $request, User $user)
    {
        $request->validate(
            [
                'status' => 'required|in:0,1',
            ]
        );

        $company = [];
        if (!is_null($request->input('company_document_approve'))) {
            $company =
                [
                    'company_document_approve' => $request->input('company_document_approve'),
                ];
        }

        if ($request->input("status") == "1") {
            $emailTemplate = EmailTemplate::where('slug', "active-account")->first();

            if (!$emailTemplate) {
                return response()->json([
                    'message' => 'Email template not found.',
                    'status' => 203,
                    'success' => true,
                ], 203);
            }

            $content = $emailTemplate->body;

            $variables = [
                'username' => $user->name,
                'companyName' => "Emlak Sepette",
                "email" => $user->email,
                "token" => $user->email_verification_token,
            ];

            foreach ($variables as $key => $value) {
                $content = str_replace("{{" . $key . "}}", $value, $content);
            }

            Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));
            DocumentNotification::create([
                'user_id' => 4,
                'text' => "Hesabınız başarıyla onaylandı. Artık platformumuzu kullanmaya başlayabilirsiniz. İyi günler dileriz!",
                'item_id' => $user->parent_id ?? $user->id,
                'link' => route('institutional.index'),
                'owner_id' => $user->parent_id ?? $user->id,
                'is_visible' => true,
            ]);
        } else {
            $emailTemplate = EmailTemplate::where('slug', "passive-account")->first();

            if (!$emailTemplate) {
                return response()->json([
                    'message' => 'Email template not found.',
                    'status' => 203,
                    'success' => true,
                ], 203);
            }

            $content = $emailTemplate->body;

            $variables = [
                'username' => $user->name,
                'companyName' => "Emlak Sepette",
                "email" => $user->email,
                "token" => $user->email_verification_token,
            ];

            foreach ($variables as $key => $value) {
                $content = str_replace("{{" . $key . "}}", $value, $content);
            }

            Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));
            DocumentNotification::create([
                'user_id' => auth()->user()->id,
                'text' => "Üzgünüz, hesabınız onaylanamadı. Lütfen belgelerinizi kontrol ederek tekrar deneyin. Yardıma ihtiyacınız olursa bizimle iletişime geçebilirsiniz.",
                'item_id' => $user->parent_id ?? $user->id,
                'link' => route('institutional.index'),
                'owner_id' => $user->parent_id ?? $user->id,
                'is_visible' => true,
            ]);
        }

        $user->update(
            array_merge(
                [
                    'tax_document_approve' => $request->input('tax_document_approve') ?? '0',
                    'record_document_approve' => $request->input('record_document_approve') ?? '0',
                    'approve_website_approve' => $request->input('approve_website_approve') ?? '0',
                    'identity_document_approve' => $request->input('identity_document_approve'),
                    'corporate_account_note' => $request->input('note'),
                    'corporate_account_status' => $request->input('status'),
                ],
                $company
            )
        );

        return redirect()->back();
    }

    public function showCorporateAccount($id)
    {
        $user_e = User::findOrFail($id);
        return view('admin.users.showCorporateStatus', compact('user_e'));
    }

    public function edit($id)
    {
        $roles = Role::where("parent_id", "4")->get();
        $userDetail = User::with("comments", "owners", "parent", "town", "child", "role", "projects", "city", "district", "neighborhood", "housings", "plan")->findOrFail($id);

        $taxOffices = TaxOffice::all();

        $parent = User::where('id', $userDetail->parent_id)->value('name');

        $projectCount     = Project::where('user_id', $userDetail->id)->count();
        $housingCount     = Housing::where('user_id', $userDetail->id)->count();
        $userChildCount   = User::where('parent_id', $userDetail->id)->count();
        $userCommentCount = count($userDetail->comments);

        $turkishAlphabet = [
            'A', 'B', 'C', 'Ç', 'D', 'E', 'F', 'G', 'Ğ', 'H', 'I', 'İ', 'J', 'K', 'L',
            'M', 'N', 'O', 'Ö', 'P', 'R', 'S', 'Ş', 'T', 'U', 'Ü', 'V', 'Y', 'Z'
        ];

        $cities = City::get();

        $towns = Town::all()->toArray();

        usort($towns, function ($a, $b) use ($turkishAlphabet) {
            $priorityCities = ["İSTANBUL", "İZMİR", "ANKARA"];
            $endPriorityLetters = ["Y", "Z"];

            // Check if $a and $b are in the priority list
            $aPriority = array_search(strtoupper($a['sehir_title']), $priorityCities);
            $bPriority = array_search(strtoupper($b['sehir_title']), $priorityCities);

            // If both are in the priority list, sort based on their position in the list
            if ($aPriority !== false && $bPriority !== false) {
                return $aPriority - $bPriority;
            }

            // If only $a is in the priority list, move it to the top
            elseif ($aPriority !== false) {
                return -1;
            }

            // If only $b is in the priority list, move it to the top
            elseif ($bPriority !== false) {
                return 1;
            }

            // If neither $a nor $b is in the priority list, sort based on the first letter of the title
            else {
                $comparison = array_search(mb_substr($a['sehir_title'], 0, 1), $turkishAlphabet) - array_search(mb_substr($b['sehir_title'], 0, 1), $turkishAlphabet);

                // If the first letters are the same, check if they are 'Y' or 'Z'
                if ($comparison === 0 && in_array(mb_substr($a['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return 1;
                } elseif ($comparison === 0 && in_array(mb_substr($b['sehir_title'], 0, 1), $endPriorityLetters)) {
                    return -1;
                }

                return $comparison;
            }
        });

        return view('admin.users.edit', compact('userDetail', 'roles', 'parent', 'projectCount', 'housingCount', 'userChildCount', 'userCommentCount', 'taxOffices', 'towns', 'cities'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $taxOfficeCity = City::where('title', $request->taxOfficeCity)->value('id');
        // Form doğrulama kurallarını tanımlayın
        $rules = [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $id,
            'type'           => 'required|in:1,2',
            'is_active'      => 'nullable',
            'iban'           => 'nullable|string|max:255',
            'corporate_type' => 'nullable|string|max:255',
            'account_type'   => 'nullable|string|max:255',
            'mobile_phone'   => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);

        // Kullanıcıyı güncelleyin
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->name           = $validatedData['name'];
        $user->username       = $validatedData['username'];
        $user->email          = $validatedData['email'];
        $user->mobile_phone   = $validatedData['mobile_phone'];
        $user->type           = $validatedData['type'];
        $user->status         = $request->has('is_active') ? 1 : 0;
        $user->taxOfficeCity  = $taxOfficeCity;
        $user->taxOffice      = $request->taxOffice;
        $user->taxNumber      = $request->taxNumber;
        $user->city_id          = $request->city_id;
        $user->county_id        = $request->county_id;
        $user->neighborhood_id  = $request->neighborhood_id;
        $user->account_type    = $request->account_type;
        $user->idNumber    =  $request->idNumber;

        if ($user->account_type == 'Şahıs Şirketi') {
            $user->idNumber = $request->idNumber;
        }

        if ($request->has('iban')) {
            $user->iban = $request->input('iban');
        }

        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }

        if ($request->has('corporate_type')) {
            $user->corporate_type = $request->input('corporate_type');
        }

        if ($request->has('account_type')) {
            $user->account_type = $request->input('account_type');
        }


        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageFileName = 'profile_image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageFileName, 'public');
            $user->profile_image = $imageFileName;
        }


        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        session()->flash('success', 'Kullanıcı başarıyla güncellendi.');

        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->delete();

        // Kullanıcı başarıyla silindiğine dair bir mesaj ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla silindi.');

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route('admin.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
    }

    public function getTaxOfficeCity(Request $request)
    {
        $taxOfficeId = $request->input('taxOfficeId');

        $taxOffice = TaxOffice::find($taxOfficeId);
        $city = $taxOffice->il;
        $plaka = $taxOffice->plaka;

        return response()->json(['city' => $city, 'plaka' => $plaka]);
    } //End

    public function expectedCall()
    {
        $expectedCall = RoleChanges::all();
        return view('admin.expected_call.index', compact('expectedCall'));
    } //End

    public function giveApproval(Request $request)
    {
        $changedUser = RoleChanges::where('user_id', $request->user_id)->first();
        $user        = User::find($request->user_id);

        $user->username             = $changedUser->username;
        $user->name                 = $changedUser->name;
        $user->store_name           = $changedUser->store_name;
        $user->phone                = $changedUser->phone;
        $user->corporate_type       = $changedUser->corporate_account_type;
        $user->city_id              = $changedUser->city_id;
        $user->county_id            = $changedUser->county_id;
        $user->neighborhood_id      = $changedUser->neighborhood_id;
        $user->account_type         = $changedUser->account_type;
        $user->taxOfficeCity        = $changedUser->taxOfficeCity;
        $user->taxOffice            = $changedUser->taxOffice;
        $user->taxNumber            = $changedUser->taxNumber;
        $user->idNumber             = $changedUser->idNumber;
        $user->subscription_plan_id = $changedUser->subscription_plan_id;
        $user->authority_licence    = $changedUser->authority_licence;

        $user->type = 2;
        $user->corporate_account_status = 0;
        $changedUser->status = 1;

        $changedUser->save();
        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı belgelerini onayladınız. Bireysel müşteri kurumsal müşteriye dönüştürüldü.');
    } //End

    public function institutionalReject(Request $request)
    {
        $changedUser = RoleChanges::where('user_id', $request->user_id)->where('status', 0)->first();
        $changedUser->status = 2;
        $changedUser->save();

        return redirect()->back()->with('info', 'Reddedildi.');
    } //End

    public function getDocuments($userId)
    {
        // Kullanıcıyı bul
        $user = User::find($userId);

        // Kullanıcının belgelerini al
        $taxDocument = $user->tax_document;
        $identityDocument = $user->identity_document;
        $companyDocument = $user->company_document;

        // Belgeleri modal içeriği olarak oluştur ve döndür
        $documentsHtml = "<h4>Vergi Belgesi</h4><a href='$taxDocument' download>Vergi Belgesi İndir</a><br>";
        $documentsHtml .= "<h4>Kimlik Belgesi</h4><a href='$identityDocument' download>Kimlik Belgesi İndir</a><br>";
        $documentsHtml .= "<h4>Şirket Belgesi</h4><a href='$companyDocument' download>Şirket Belgesi İndir</a>";

        return $documentsHtml;
    } //End

    public function awaitingCalled()
    {
        $users = User::where('type', 2)->where('corporate_account_status', 0)->orderby('updated_at', 'desc')->get();
        return view('admin.awaiting-called.index', compact('users'));
    } //End

    public function mailVerification(Request $request)
    {
        $user  = User::find($request->id);

        $emailTemplate = EmailTemplate::where('slug', 'account-confirmation')->first();

        // if ( !$emailTemplate ) {
        //     return response()->json( [
        //         'message' => 'Email template not found.',
        //         'status' => 203,
        //         'success' => true,
        //     ], 203 );
        // }

        $content = $emailTemplate->body;

        $variables = [
            'username' => $user->name,
            'companyName' => 'Emlak Sepette',
            'email' => $user->email,
            'token' => $user->email_verification_token,
            'verificationLink' => URL::to("/verify-email/{$user->email_verification_token}"),
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));

        return redirect()->back()->with('success', 'Doğrulama linki gönderildi.');
    } //End

    public function smsVerification(Request $request)
    {
        $verificationCode = mt_rand(100000, 999999); // Rastgele 6 haneli bir doğrulama kodu oluşturuluyor

        $user = User::find($request->id); // Mevcut kullanıcıyı alıyoruz

        if ($user) {
            $user->phone_verification_code = $verificationCode; // Kullanıcıya doğrulama kodunu atıyoruz
            $user->phone_verification_status = 0; // Doğrulama durumunu 0 olarak ayarlıyoruz
            $user->save(); // Kullanıcıyı kaydediyoruz
            if ($user->phone_verification_code) {
                $this->sendSMS($user);
            }

            return redirect()->back();
        }
    } //End

    public function searched(Request $request)
    {
        $user = User::find($request->id);

        $user->is_called = 1;
        $user->save();
        // print_r($user);die;
        return redirect()->back();
    } //End

    public function documentLoadPage(Request $request)
    {
        $user = User::find($request->id);

        $user->is_show_files = 1;
        $user->save();

        return redirect()->back();
    } //End
}
