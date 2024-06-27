<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CancelRequest;
use App\Models\CartOrder;
use App\Models\Collection;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\Project;
use App\Models\ProjectFavorite;
use App\Models\Reservation;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\SmsService;

class DashboardController extends Controller
{

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }


    public function getReservations()
    {
        $user = Auth::user();

        $housingReservations = Reservation::select( 'reservations.*' )
        ->with( 'user', 'housing', 'owner' )->where( 'status', '=', 1 )
        ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
        ->whereNull( 'cancel_requests.id' )
        ->where("owner_id", $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
        $confirmReservations = Reservation::select( 'reservations.*' )
        ->with( 'user', 'housing', 'owner' )
        ->where("owner_id", $user->id)
        ->where( 'status', '!=', 3 )
        ->where( 'status', '!=', 1 )
        ->where( 'check_in_date', '>=', date( 'Y-m-d' ) )
        ->where( 'status', '!=', 3 )
        ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
        ->whereNull( 'cancel_requests.id' )
        ->orderBy('created_at', 'desc')
        ->get();

        $expiredReservations = Reservation::select( 'reservations.*' )
        ->with( 'user', 'housing', 'owner' )
        ->where( 'check_in_date', '<=', date( 'Y-m-d' ) )
        ->where( 'status', '!=', 3 )
        ->where("owner_id", $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $cancelReservations = Reservation::select( 'reservations.*' )
        ->with( 'user', 'housing', 'owner' )
        ->where( 'status', '=', 3 )
        ->where("owner_id", $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $cancelRequestReservations = Reservation::select( 'reservations.*' )->with( 'user', 'housing', 'owner' )
        ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
        ->where("owner_id", $user->id)
        ->where( 'status', '!=', 3 )->whereNotNull( 'cancel_requests.id' )
        ->orderBy('created_at', 'desc')
        ->get();

        $refundedReservations = Reservation::whereHas('refund')
        ->with('user', 'housing', 'owner', 'refund')
        ->where('owner_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();


        return view('client.panel.reservations.index', compact( 'housingReservations', 'cancelReservations', 'expiredReservations', 'confirmReservations', 'cancelRequestReservations','refundedReservations' ) );

    }

    public function getMyReservations()
    {
        $user = Auth::user();
        $housingReservations = Reservation::with("user", "housing", "owner")
           
            ->where('status', '!=', 3)
            ->get();


            $housingReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'status', '=', 1 )
            ->where("user_id", $user->id)
            ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
            ->whereNull( 'cancel_requests.id' )
            ->orderBy('created_at', 'desc')
            ->get();

            $confirmReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'status', '!=', 3 )
            ->where( 'status', '!=', 1 )
            ->where("user_id", $user->id)
            ->where( 'check_in_date', '>=', date( 'Y-m-d' ) )
            ->where( 'status', '!=', 3 )
            ->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
            ->whereNull( 'cancel_requests.id' )
            ->orderBy('created_at', 'desc')
            ->get();
    
            $expiredReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'check_in_date', '<=', date( 'Y-m-d' ) )
            ->where( 'status', '!=', 3 )
            ->where("user_id", $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    
            $cancelReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )
            ->where( 'status', '=', 3 )
            ->where("user_id", $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    
            $cancelRequestReservations = Reservation::select( 'reservations.*' )
            ->with( 'user', 'housing', 'owner' )->leftJoin( 'cancel_requests', 'cancel_requests.reservation_id', '=', 'reservations.id' )
            ->where("user_id", $user->id)
            ->where( 'status', '!=', 3 )->whereNotNull( 'cancel_requests.id' )
            ->orderBy('created_at', 'desc')
            ->get();


            $refundedReservations = Reservation::whereHas('refund')
            ->with('user', 'housing', 'owner', 'refund')
            ->where('owner_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

    
            return view( 'institutional.reservations.get', compact('refundedReservations','housingReservations', 'cancelReservations', 'expiredReservations', 'confirmReservations', 'cancelRequestReservations' ) );
    }

    public function cancelReservationRequest(Request $request, $id)
    {
        CancelRequest::create([
            "reservation_id" => $id,
            "description" => $request->input('reservation_cancel_text'),
            "iban" => $request->input('iban'),
            "iban_name" => $request->input('iban_name'),
            "item_type" => 1,
        ]);

        return redirect()->route('institutional.myreservations', ["status" => "cancel_reservation_request"]);
    }

    public function cancelReservationCancel($id)
    {
        CancelRequest::where('id', $id)->delete();

        return [
            "status" => true
        ];
    }


    public function getOrders()
    {
        $user = User::where("id", Auth::user()->id)->with("projects", "housings")->first();
        $userProjectIds = $user->projects->pluck('id')->toArray();

        // Projects için sorgu
        $projectOrders = CartOrder::select('cart_orders.*')
            ->with("user", "invoice", "reference")
            ->where(function ($query) use ($userProjectIds) {
                $query->whereIn(
                    DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id'))"),
                    $userProjectIds
                );
            })
            ->orderBy('created_at', 'DESC')
            ->where("is_disabled", NULL)
            ->get();


        $userHousingIds = $user->housings->pluck('id')->toArray();

        $housingOrders = CartOrder::select('cart_orders.*')
            ->with("user", "invoice", "reference")
            ->where(function ($query) use ($userHousingIds) {
                $query->whereIn(
                    DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id'))"),
                    $userHousingIds
                );
            })
            ->orderBy('created_at', 'DESC')
            ->get();


        $cartOrders = $projectOrders->merge($housingOrders);

        return view('client.panel.orders.index', compact('cartOrders'));
    }

    public function corporateAccountVerification()
    {
        return view('client.panel.home.verification');
    }


    public function corporateAccountWaiting()
    {
        return view('client.panel.home.waiting');
    }

    public function corporateHasClubAccountVerification()
    {
        return view('client.panel.home.has-club-verification');
    }
    public function corporateHasClubAccountVerificationStatus()
    {
        return view('client.panel.home.has-club-status');
    }

    public function phoneUpdate(Request $request)
    {

        $user = auth()->user();
        $user->mobile_phone = $request->input('new_mobile_phone');
        $user->save();

        return redirect()->back()->with('success', 'Telefon numaranız başarıyla güncellendi.');
    }

    public function phoneVerification()
    {
        $user = Auth::user();
        return view('client.panel.home.phone-verification', compact('user'));
    }

    public function generateVerificationCode()
    {

        $verificationCode = mt_rand(100000, 999999); // Rastgele 6 haneli bir doğrulama kodu oluşturuluyor

        $user = auth()->user(); // Mevcut kullanıcıyı alıyoruz

        if ($user) {
            $user->phone_verification_code = $verificationCode; // Kullanıcıya doğrulama kodunu atıyoruz
            $user->phone_verification_status = 0; // Doğrulama durumunu 0 olarak ayarlıyoruz
            $user->save(); // Kullanıcıyı kaydediyoruz
            if ($user->phone_verification_code) {
                $this->sendSMS($user);
            }

            return redirect()->route('institutional.phone.verification');
        }
    }

    private function sendSMS($user)
    {
        // Kullanıcının telefon numarasını al
        $userPhoneNumber = $user->mobile_phone;

        // Kullanıcının adını ve soyadını al
        $name = $user->name;

        // SMS metni oluştur
        $message = "$user->phone_verification_code nolu onay kodu ile hesabınızı güvenli bir şekilde doğrulayabilirsiniz.";

        // SMS gönderme işlemi
        $smsService = new SmsService();
        $source_addr = 'Emlkspette';

        $smsService->sendSms($source_addr, $message, $userPhoneNumber);
    }

    public function verifyPhoneNumber(Request $request)
    {
        $user = auth()->user(); // Mevcut kullanıcıyı alıyoruz

        if ($user) {
            $verificationCode = implode('', $request->input('code')); // Kodları birleştir

            if ($verificationCode == $user->phone_verification_code) {
                $user->phone_verification_status = 1; // Doğrulama durumunu 1 olarak ayarlıyoruz
                $user->save(); // Kullanıcıyı kaydediyoruz
                return redirect()->route('institutional.index');
            } else {
                return redirect()->back()->withErrors(['error' => 'Doğrulama Kodu Eşleşmedi']);
            }
        }
    }
    public function verifyAccount(Request $request)
    {
        $request->validate(
            [
                'vergi_levhasi' => 'nullable',
                'sicil_belgesi' => 'nullable',
                'kimlik_belgesi' => 'nullable',
                'insaat_belgesi' => 'nullable',
                "approve_website" => "nullable"
            ]
        );

        $array = [];

        if ($request->hasFile('vergi_levhasi')) {
            $image = $request->file('vergi_levhasi');
            $imageFileName = 'tax_document_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/tax_documents', $imageFileName);
            $image->move(public_path('tax_documents'), $imageFileName);
            $array = array_merge($array, ['tax_document' => $imageFileName]);
        }

        if ($request->hasFile('sicil_belgesi')) {
            $image = $request->file('sicil_belgesi');
            $imageFileName = 'record_document_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/record_documents', $imageFileName);
            $image->move(public_path('record_documents'), $imageFileName);
            $array = array_merge($array, ['record_document' => $imageFileName]);
        }

        if ($request->hasFile('kimlik_belgesi')) {
            $image = $request->file('kimlik_belgesi');
            $imageFileName = 'identity_document_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('identity_documents'), $imageFileName);
            $array = array_merge($array, ['identity_document' => $imageFileName]);
        }

        if ($request->hasFile('insaat_belgesi')) {
            $image = $request->file('insaat_belgesi');
            $imageFileName = 'company_document_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('company_documents'), $imageFileName);
            $array = array_merge($array, ['company_document' => $imageFileName]);
        }


        if ($request->hasFile('approve_website')) {
            $image = $request->file('approve_website');
            $imageFileName = 'approve_website_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('approve_websites'), $imageFileName);
            $array = array_merge($array, ['approve_website' => $imageFileName]);
        }

        auth()->user()->update($array);

        $emailTemplate = EmailTemplate::where('slug', "send-files")->first();

        if (!$emailTemplate) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $content = $emailTemplate->body;
        $user = User::where("id", auth()->user()->parent_id ?? auth()->user()->id)->first();

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
            'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'text' => "Belgeleriniz Emlak Sepette Yönetimine İletildi",
            'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'link' => route('institutional.index'),
            'owner_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'is_visible' => true,
        ]);

        $emailAdminTemplate = EmailTemplate::where('slug', "get-files")->first();

        if (!$emailAdminTemplate) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $contentAdmin = $emailAdminTemplate->body;

        $admins = User::where("type", "3")->get();

        foreach ($admins as $key => $admin) {
            DocumentNotification::create([
                'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                'text' => 'Hesap onayı için yeni bir belge gönderildi. Kullanıcı: ' . auth()->user()->email,
                'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
                'link' => route('admin.user.show-corporate-account', ['user' => auth()->user()->parent_id ?? auth()->user()->id]),
                'owner_id' => 4,
                'is_visible' => true,
            ]);

            $adminVariables = [
                'username' => $user->name,
                'adminName' => $admin->name,
                'companyName' => "Emlak Sepette",
                "email" => $user->email,
                "token" => $user->email_verification_token,
            ];

            foreach ($adminVariables as $key => $value) {
                $contentAdmin = str_replace("{{" . $key . "}}", $value, $contentAdmin);
            }

            Mail::to($admin->email)->send(new CustomMail($emailAdminTemplate->subject, $contentAdmin));
        }

        return redirect()->back();
    }

    public function index()
    {
        $userLog = User::where("id", Auth::user()->id)->with("plan.subscriptionPlan", "parent")->first();
        $projectCounts = Project::where("user_id",  auth()->user()->parent_id ?? auth()->user()->id)->where("status", "1")->count();
        $housingCounts = Housing::where("user_id",  auth()->user()->parent_id ?? auth()->user()->id)->where("status", "1")->count();
        $housingFavorites = HousingFavorite::where("user_id", auth()->user()->id)->count();
        $projectFavorites = ProjectFavorite::where("user_id", auth()->user()->id)->count();

        $hasPlan = UserPlan::where("user_id", auth()->user()->parent_id ?? auth()->user()->id)->with("subscriptionPlan")->first();
        $remainingPackage = UserPlan::where("user_id", auth()->user()->parent_id ?? auth()->user()->id)->where("status", "1")->first();
        $stats1_data = [];

        DB::beginTransaction();
        for ($i = 1; $i <= date('m'); ++$i) {
            $n = $i + 1;
            if ($i == date('m')) {
                $stats1_data[] = DB::table('housings')->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            } else {
                $stats1_data[] = DB::table('housings')->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            }
        }
        DB::commit();

        $stats2_data = [];

        DB::beginTransaction();
        for ($i = 1; $i <= date('m'); ++$i) {
            $n = $i + 1;
            if ($i == date('m')) {
                $stats2_data[] = DB::table('projects')->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            } else {
                $stats2_data[] = DB::table('projects')->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            }
        }
        DB::commit();

        $user_id = Auth::user()->id;

        $balanceStatus0Lists = SharerPrice::where("user_id", $user_id)
            ->where("status", "0")->get();

        $balanceStatus0 = SharerPrice::where("user_id", $user_id)
            ->where("status", "0")
            ->sum('balance');

        $balanceStatus1Lists = SharerPrice::where("user_id", $user_id)
            ->where("status", "1")->get();

        $balanceStatus1 = SharerPrice::where("user_id", $user_id)
            ->where("status", "1")
            ->sum('balance');


        $balanceStatus2Lists = SharerPrice::where("user_id", $user_id)
            ->where("status", "2")->get();

        $balanceStatus2 = SharerPrice::where("user_id", $user_id)
            ->where("status", "2")
            ->sum('balance');

        $collections = Collection::with("links")->where("user_id", Auth::user()->id)->orderBy("id","desc")->limit(6)->get();
        $totalStatus1Count = $balanceStatus1Lists->count();
        $successPercentage = $totalStatus1Count > 0 ? ($totalStatus1Count / ($totalStatus1Count + $balanceStatus0Lists->count() + $balanceStatus2Lists->count())) * 100 : 0;

        return view('client.panel.home.index', compact("userLog", "housingCounts", "housingFavorites", "projectFavorites", "projectCounts", "balanceStatus0", "successPercentage", "collections", "balanceStatus1", "balanceStatus2", "balanceStatus0Lists", "balanceStatus1Lists", "balanceStatus2Lists", "remainingPackage", "stats1_data", "stats2_data", "hasPlan"));
    }
}
