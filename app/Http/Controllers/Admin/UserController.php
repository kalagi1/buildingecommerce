<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Role;
use App\Models\User;
use App\Models\Chat;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
    public function messages(){
        $chats = Chat::with("messages","user")->get();
        return view("admin.chat.index", compact("chats"));
    }

    public function blockUser(User $user)
    {
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
            return redirect()->back()->with('success', 'Kullanıcı engellendi.');
        }
    }

    public function orders(Request $request)
    {
        $brands = User::where("type", "2")->where("status", "1")->where("corporate_account_status","1")->orderBy("order","asc")->get();
return view('admin.users.orders', compact('brands'));


    }

    public function updateOrder(Request $request)
    {
        foreach ($request->input('orders') as $key => $order) {
            User::where('id', $order['id'])->update(['order' => $key +1]);
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
    public function store( Request $request ) {
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

        $validatedData = $request->validate( $rules, $messages );
        $mainUser = User::where( 'id', auth()->user()->parent_id ?? auth()->user()->id )->with( 'plan' )->first();
        $countUser = UserPlan::where( 'user_id', $mainUser->id )->first();
        $users = User::where( 'parent_id', auth()->user()->parent_id ?? auth()->user()->id )->get();
        $userCount = User::all();
        $lastUser = User::latest()->first();

        $user = new User();
        $user->name = $validatedData[ 'name' ];
        $user->email = $validatedData[ 'email' ];
        $user->profile_image = 'indir.png';
        $user->password = bcrypt( $validatedData[ 'password' ] );
        // Şifreyi şifreleyin
        $user->type = $validatedData[ 'type' ];
        $user->status = $request->has( 'is_active' ) ? 1 : 5;
        $user->corporate_account_status = 1;
        $user->parent_id = ( auth()->user()->parent_id ?? auth()->user()->id ) != 3 ? ( auth()->user()->parent_id ?? auth()->user()->id ) : null;
        $user->code = $lastUser->id + auth()->user()->id  + 1000000;
        $user->subscription_plan_id = $mainUser->subscription_plan_id;

        $user->save();

        if ( $user->save() ) {
            $countUser->user_limit = $countUser->user_limit - 1;
            $countUser->save();
        }

        Chat::create( [
            'user_id' => $user->id
        ] );

        session()->flash( 'success', 'Kullanıcı başarıyla oluşturuldu.' );

        return redirect()->route( 'admin.users.index' );

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
                    'identity_document_approve' => $request->input('identity_document_approve'),
                    'corporate_account_note' => $request->input('note'),
                    'corporate_account_status' => $request->input('status'),
                ], $company)
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
        $roles = Role::all();
        $userDetail = User::with("comments", "owners", "parent", "town", "child", "role", "projects", "city", "district", "neighborhood", "housings", "plan")->findOrFail($id);
        return view('admin.users.edit', compact('userDetail', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Form doğrulama kurallarını tanımlayın
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'type' => 'required|in:1,2',
            'is_active' => 'nullable',
        ];

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);

        // Kullanıcıyı güncelleyin
        $user = User::findOrFail($id); // Kullanıcıyı bulun veya hata döndürün
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->type = $validatedData['type'];
        $user->status = $request->has('is_active') ? 1 : 0;

        
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageFileName = 'profile_image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageFileName, 'public');
            $user->profile_image = $imageFileName; // Vergi Dairesi İli güncellendi
        }
        

        // Şifre güncelleme işlemini kontrol edin
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Kullanıcıyı veritabanına kaydedin
        $user->save();

        // Başarılı bir işlem sonrası mesajı ayarlayın
        session()->flash('success', 'Kullanıcı başarıyla güncellendi.');

        // Kullanıcıları listeleme sayfasına yönlendirme yapabilirsiniz
        return redirect()->route('admin.users.index'); // index route'unu kullanarak kullanıcıları listeleme sayfasına yönlendirme
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
}
