<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CartOrder;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Reservation;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function getReservations() {
        $user = Auth::user();
        $housingReservations = Reservation::with("user", "housing")
            ->where("owner_id", $user->id)
            ->get();

            return view('institutional.reservations.index', compact('housingReservations'));

    }
    public function getMyReservations() {
        $user = Auth::user();
        $housingReservations = Reservation::with("user", "housing","owner")
            ->where("user_id", $user->id)
            ->get();

    return view('institutional.reservations.get', compact('housingReservations'));

    }
    

    public function getOrders()
    {
        $user = Auth::user();
        $userProjectIds = $user->projects->pluck('id')->toArray();
    
        // Projects için sorgu
        $projectOrders = CartOrder::select('cart_orders.*')
            ->with("user", "invoice")
            ->where(function ($query) use ($userProjectIds) {
                $query->whereIn(
                    DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id'))"),
                    $userProjectIds
                )->where('cart_orders.status', '1');
            })
            ->get();
    
        // Housings için sorgu
        $housingOrders = CartOrder::select('cart_orders.*')
            ->with("user", "invoice")
            ->where(function ($query) use ($userProjectIds) {
                $query->whereIn(
                    DB::raw("JSON_UNQUOTE(JSON_EXTRACT(cart, '$.item.id'))"),
                    $userProjectIds
                )->where('cart_orders.status', '1');
            })
            ->orWhereIn('cart_orders.cart', function($subQuery) use ($user) {
                $subQuery->select('cart')
                    ->from('housings')
                    ->where('user_id', $user->id);
            })
            ->get();
    
        $cartOrders = $projectOrders->merge($housingOrders);

    
        return view('institutional.orders.index', compact('cartOrders'));
    }
    
    public function corporateAccountVerification()
    {
        return view('institutional.home.verification');
    }

    public function verifyAccount(Request $request)
    {
        $request->validate(
            [
                'vergi_levhasi' => 'nullable|image|mimes:jpg,jpeg,png',
                'sicil_belgesi' => 'nullable|image|mimes:jpg,jpeg,png',
                'kimlik_belgesi' => 'nullable|image|mimes:jpg,jpeg,png',
                'insaat_belgesi' => 'nullable|image|mimes:jpg,jpeg,png',
            ]
        );

        $array = [];

        if ($request->hasFile('vergi_levhasi')) {
            $file1 = $request->vergi_levhasi->store('tax_documents');
            $array = array_merge($array, ['tax_document' => $file1]);
        }

        if ($request->hasFile('sicil_belgesi')) {
            $file2 = $request->sicil_belgesi->store('record_documents');
            $array = array_merge($array, ['record_document' => $file2]);
        }

        if ($request->hasFile('kimlik_belgesi')) {
            $file3 = $request->kimlik_belgesi->store('identity_documents');
            $array = array_merge($array, ['identity_document' => $file3]);
        }

        if ($request->hasFile('insaat_belgesi')) {
            $file4 = $request->insaat_belgesi->store('company_documents');
            $array = array_merge($array, ['company_document' => $file4]);
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
        return view('institutional.home.index', compact("userLog", "remainingPackage", "stats1_data", "stats2_data","hasPlan"));
    }
}
