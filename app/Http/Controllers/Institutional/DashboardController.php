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
use App\Models\Bid;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\SmsService;
use Carbon\Carbon;

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

    
            return view( 'client.panel.reservations.get', compact('refundedReservations','housingReservations', 'cancelReservations', 'expiredReservations', 'confirmReservations', 'cancelRequestReservations' ) );
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

    public function index(){
        $user = auth()->user();
        $housingViews = $this->housingViews();
        $housingSalesStatistics = $this->salesStatistics();
        $housings = $this->housings();
        $pendingJobs = $this->pendingJobs();
        $monthlyCounts = $this->getMonthlyCounts();
        $monthlyCollectionCounts = $this->getMonthlyCollectionCounts(); // Adjusted variable name

        $subWorkerCount  = $this->subWorkerCount();

        $activeAdvertProjects    = $this->activeAdvertProjects();
        $activeAdvertHousings    = $this->activeAdvertHousings();
        
        $pendingAdvertProjects  = $this->pendingAdvertProjects();
        $pendingAdvertHousings  = $this->pendingAdvertHousings();

        $passiveAdvertProjects  = $this->passiveAdvertProjects();
        $passiveAdvertHousings  = $this->passiveAdvertHousings();

        $collectionCount = $this->collectionCount();

        $viewCountProjects       = $this->viewCountProjects();
        $viewCountHousings       = $this->viewCountHousings();

        $totalAdvertProjects   = $this->totalAdvertProjects();
        $totalAdvertHousings   = $this->totalAdvertHousings();
        $bidsCount       = $this->bidsCount();

        return view('client.panel.home.index2', compact(
            'housingViews',
            'housingSalesStatistics',
            'housings',
            'pendingJobs',
            'monthlyCounts',
            'monthlyCollectionCounts', 
            'subWorkerCount',
            'activeAdvertProjects',
            'activeAdvertHousings',
            'pendingAdvertProjects',
            'pendingAdvertHousings',
            'totalAdvertProjects',
            'totalAdvertHousings',
            'passiveAdvertProjects',
            'passiveAdvertHousings',
            'collectionCount',
            'viewCountProjects',
            'viewCountHousings',
            'bidsCount'
        ));
    }
    //sadece kurumsallar için yapıldı 

    //alt çalışan sayısı
    private function subWorkerCount(){
        $user = Auth::user();
        $subWorkerCount = User::where('parent_id', $user->id)->count();
        return $subWorkerCount;
    }//End

    //aktif ilan sayısı
    private function activeAdvertProjects(){
        $user = Auth::user();
        $activeAdvertProjects = Project::where('status','1')->where('user_id', $user->id)->count();
        return $activeAdvertProjects;
    }//End    

    private function activeAdvertHousings(){
        $user = Auth::user();
        $activeAdvertHousings = Housing::where('status','1')->where('user_id', $user->id)->count();
        return $activeAdvertHousings;
    }//End    

    //onay bekleyen ilanlar
    private function pendingAdvertProjects(){
        $user = Auth::user();
        $pendingAdvertProjects = Project::where('status','2')->where('user_id', $user->id)->count();
        return $pendingAdvertProjects;
    }//End

    private function pendingAdvertHousings(){
        $user = Auth::user();
        $pendingAdvertHousings = Housing::where('status','2')->where('user_id', $user->id)->count();
        return $pendingAdvertHousings;
    }//End               

    //toplam ilan sayısı
    private function totalAdvertProjects(){
        $user = Auth::user();
        $totalAdvertProjects = Project::where('user_id', $user->id)->count();
        return $totalAdvertProjects;
    }//End

    private function totalAdvertHousings(){
        $user = Auth::user();
        $totalAdvertHousings = Housing::where('user_id', $user->id)->count();
        return $totalAdvertHousings;
    }//End
    
    //pasif ilan sayısı
    private function passiveAdvertProjects(){
        $user = Auth::user();
        $passiveAdvertProjects = Project::where('status','0')->where('user_id', $user->id)->count();
        return $passiveAdvertProjects;
    }//End  
    
    private function passiveAdvertHousings(){
        $user = Auth::user();
        $passiveAdvertHousings = Housing::where('status','0')->where('user_id', $user->id)->count();
        return $passiveAdvertHousings;
    }//End   

    //Koleksiyon Sayısı
    private function collectionCount(){
        $user = Auth::user();
        $collectionCount = Collection::where('user_id', $user->id)->count();
        return $collectionCount;
    }//End    

    //Görüntülenme Sayısı
    private function viewCountProjects(){
        $user = Auth::user();
        $viewCountProjects = Project::where('user_id', $user->id)->pluck('view_count');
        return $viewCountProjects;
    }//End    

    private function viewCountHousings(){
        $user = Auth::user();
        $viewCountHousings = Housing::where('user_id', $user->id)->pluck('view_count');
        return $viewCountHousings;
    }//End    

    //Pazar Teklifleri
    private function bidsCount(){
        $user = Auth::user();
        $bidsCount = Bid::where('user_id',$user->id)->count();
        return $bidsCount;    
    }//End    
    
    
    /**
     * TODO: Ziyaretci Sayısı son 24 saat
     * TODO: Grafik-Performans Verileri (yayındaki ilanlar , Görüntülenme, Favoriye Alınma, Koleksiyona Alınma)
     * TODO: Satış istatistikleri (Toplam Satış, Bugünki satış, Son 1 ayki satış) count ve toplam para
     * TODO: Son 3 ilan 
     * TODO: Bekleyen İşler (count)
     * 
     */

    
    public function getMonthlyCollectionCounts()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Şu anki tarihi ve yılı alalım
        $today = Carbon::today();
        $currentYear = $today->year;
        $currentMonth = $today->month;

        // Koleksiyona alınma tarihlerine göre gruplanmış ve item_type'a göre filtrelenmiş verileri alalım
        $monthlyCollections = DB::table('share_links')
            ->selectRaw('MONTH(created_at) as month, item_type, ROUND(count(*)) as count')
            ->where('user_id', $userId)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->whereIn('item_type', [1, 2]) // 1: Proje, 2: Emlak
            ->groupBy('month', 'item_type')
            ->orderBy('month')
            ->get();

        // Tüm ayları içeren bir dizi oluştur
        $allMonths = [
            'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran',
            'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'
        ];

        // Grafik için gerekli formatı oluşturalım
        $months = [];
        $countsProjects = [];
        $countsListings = [];

        // Şu anki yıl için ayarlara yerleştirelim
        foreach ($allMonths as $index => $month) {
            if ($index + 1 <= $currentMonth) {
                $months[] = $month;
                $countsProjects[] = 0;
                $countsListings[] = 0;
            }
        }

        // Koleksiyon verilerini ayarlara yerleştirelim
        foreach ($monthlyCollections as $collection) {
            $index = $collection->month - 1; // Array indexleri 0'dan başladığı için -1
            if ($collection->item_type == 1) {
                $countsProjects[$index] += $collection->count;
            } elseif ($collection->item_type == 2) {
                $countsListings[$index] += $collection->count;
            }
        }

        return [
            'months' => json_encode($months),
            'countsProjects' => json_encode($countsProjects),
            'countsListings' => json_encode($countsListings),
            'user' => $user,
            
        ];
    }        
        
    public function getMonthlyCounts()
    {
        $user = Auth::user(); 
        $userId = $user->id;

        // Şu anki tarihi ve yılı alalım
        $today = Carbon::today();
        $currentYear = $today->year;
        $currentMonth = $today->month;

        // İlanların yayınlanma tarihlerine göre gruplanmış verileri alalım
        $monthlyListings = Housing::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->selectRaw('count(*) as totalCount')
            ->where('status', 1)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->when($user->type == 1, function ($query) use ($userId) {
                return $query->where('owner_id', $userId); // owner_id olarak ayarlayın
            }, function ($query) use ($userId) {
                return $query->where('user_id', $userId); // user_id olarak ayarlayın
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Projelerin yayınlanma tarihlerine göre gruplanmış verileri alalım
        $monthlyProjects = Project::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId)
                      ->where('type', 2); // User modelindeki type alanı 2 olan kullanıcıları filtrele
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Tüm ayları içeren bir dizi oluştur
        $allMonths = [
            'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran',
            'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'
        ];

        // Grafik için gerekli formatı oluşturalım
        $monthsListings = [];
        $countsListings = [];
        $monthsProjects = [];
        $countsProjects = [];

        // Şu anki yıl için ayırlara yerleştirelim
        foreach ($allMonths as $index => $month) {
            if ($index + 1 <= $currentMonth) {
                $monthsListings[] = $month;
                $countsListings[] = 0;
                $monthsProjects[] = $month;
                $countsProjects[] = 0;
            }
        }

        // İlan verilerini ayarlara yerleştirelim
        foreach ($monthlyListings as $listing) {
            $index = $listing->month - 1; // Array indexleri 0'dan başladığı için -1
            $countsListings[$index] = $listing->count;
        }

        // Proje verilerini ayarlara yerleştirelim
        foreach ($monthlyProjects as $project) {
            $index = $project->month - 1; // Array indexleri 0'dan başladığı için -1
            $countsProjects[$index] = $project->count;
        }
        

        return [
            'monthsListings' => json_encode($monthsListings),
            'countsListings' => json_encode($countsListings),
            'totalCountListings' => $monthlyListings->sum('totalCount'),
            'monthsProjects' => json_encode($monthsProjects),
            'countsProjects' => json_encode($countsProjects),
            'totalCountProjects' => $monthlyProjects->sum('count'),
            'user' => $user,
        ];
    }

    private function pendingJobs(){

        $user = Auth::user(); 
        $userId = $user->id;
    
        $totalListingCount  = Housing::where('user_id',$userId)->count();
        $listingsPendingApprovalCount  = Housing::where('user_id',$userId)->where('status', 0)->count();
        $activeListingsCount = Housing::where('user_id',$userId)->where('status', 1)->count();
        $listingsSuspended = Housing::where('user_id',$userId)->where('status', 3)->count();
        $CollectionCount = Collection::where('user_id',$userId)->count();
        $SubordinateCount = User::where('parent_id',$userId)->count();
        $marketOffers =  Bid::where('user_id',$userId)->count();

        return [
            'totalListingCount' =>$totalListingCount,
            'listingsPendingApprovalCount' =>$listingsPendingApprovalCount,
            'activeListingsCount' => $activeListingsCount,
            'listingsSuspended' => $listingsSuspended,
            'CollectionCount' => $CollectionCount,
            'SubordinateCount' => $SubordinateCount,
            'marketOffers' =>  $marketOffers,
            'user' =>  $user ,
        ];  
    }

    private function housingViews()
    {
        $user = Auth::user();
        $userId = $user->id;

        $housingViews = Housing::where('status', 1) 
        ->orderBy('view_count', 'desc') 
        ->where('user_id', $userId)
        ->limit(3) 
        ->get();
       
        return $housingViews;
    }

    private function housings()
    {
        $user = Auth::user();
        $userId = $user->id;

        $housings= Housing::where('status', 1) 
        ->orderBy('created_at', 'desc') 
        ->where('user_id', $userId)
        ->limit(3) 
        ->get();

        return $housings;
    }

    private function salesStatistics()
    {
        $user = Auth::user(); 
        $userId = $user->id;
    
        $today = Carbon::today()->toDateString();
        $lastMonth = Carbon::now()->subMonth()->toDateString();
    
        // Tüm verileri al
        $cartOrdersQuery = CartOrder::where('status', '1')
            ->where('store_id', $userId)
            ->whereNull('is_disabled')
            ->get();
    
        $todaySalesQuery = CartOrder::where('status', '1')
            ->where('store_id', $userId)
            ->whereNull('is_disabled')
            ->whereDate('created_at', $today)
            ->get();
    
        $lastMonthSalesQuery = CartOrder::where('status', '1')
            ->where('store_id', $userId)
            ->whereNull('is_disabled')
            ->whereDate('created_at', '>=', $lastMonth)
            ->get();
    
        // Toplam Satış
        $totalSales = $cartOrdersQuery->count();
    
        // Bugünün Satışları
        $todaySales = $todaySalesQuery->count();
    
        // Geçen Ayın Satışları
        $lastMonthSales = $lastMonthSalesQuery->count();
    
        // Toplam Gelir
        $totalRevenue = $cartOrdersQuery->sum(function($order) {
            return floatval(str_replace(',', '.', str_replace('.', '', $order->amount)));
        });
    
        // Günlük Gelir
        $dailyRevenue = $todaySalesQuery->sum(function($order) {
            return floatval(str_replace(',', '.', str_replace('.', '', $order->amount)));
        });
    
        // Aylık Gelir
        $monthlyRevenue = $lastMonthSalesQuery->sum(function($order) {
            return floatval(str_replace(',', '.', str_replace('.', '', $order->amount)));
        });
    
        return [
            'totalSales' => $totalSales,
            'todaySales' => $todaySales,
            'lastMonthSales' => $lastMonthSales,
            'totalRevenue' => $totalRevenue,
            'dailyRevenue' => $dailyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'user' => $user,
        ];
    }

}
