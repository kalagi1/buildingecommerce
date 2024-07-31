<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AssignedUser;
use App\Models\Project;
use App\Models\User;
use App\Models\Award;
use App\Models\CancelRequest;
use App\Models\CartOrder;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    public function index(){
        return view('client.panel.crm.index');
    }
    public function approveReservation( Reservation $reservation ) {
        $reservation->update( [ 'status' => '1' ] );
        return redirect()->back();
    }

    public function unapproveReservation( Reservation $reservation ) {
        $reservation->update( [ 'status' => '3' ] );
        CancelRequest::where( 'reservation_id', $reservation->id )->delete();
        return redirect()->back();
    }
    public function projectAssigment(){
        return view('client.panel.crm.project_assigment');
    }//End

    public function salesConsultantList() {
        $sales_consultant = User::where('project_authority', 'on')->get();
        $projects = Project::where('status', '1')->get();
        // print_r($sales_consultant);die;
    
        // Danışmanlar için atanmış projeleri çek
        $consultantsWithProjects = [];
        foreach ($sales_consultant as $consultant) {
            $assignedProjects = DB::table('project_assigment')
                ->where('user_id', $consultant->id)
                ->pluck('project_id')
                ->toArray();
    
            $consultantsWithProjects[$consultant->id] = $assignedProjects;
        }
    
        return view('client.panel.sales_consultant.index', compact('sales_consultant', 'projects', 'consultantsWithProjects'));
    }//End

    public function assignProjectUser(Request $request){
        $projectIds = $request->projectIds;

        foreach ($projectIds as $projectId) {
            DB::table('project_assigment')->insert([
                'user_id'    => $request->user_id,
                'project_id' => $projectId,
                'created_at' => now()
            ]);
        }
      
      return redirect()->back()->with('success','Proje ataması başarıyla yapıldı.');  
    }//End

    public function consultantCustomerList(){
        // $customers = DB::table('assigned_users')->where('danisman_id',Auth::id())->get(); // Yeni Müşteriler //arama kaydı olmayanları listele sorguyu güncelle

        // $tum_musteriler = DB::table('assigned_users')

        // $customers = DB::table('assigned_users')->get(); //Tüm Müşteriler

        $customers = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->whereNull('customer_calls.customer_id')
            ->select('assigned_users.*')
            ->get();
            $customerCount = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->whereNull('customer_calls.customer_id')
            ->select('assigned_users.*')
            ->count();   


      
        $tum_musteriler = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->select(
                'assigned_users.*',
                'customer_calls.meet_type as gorusme_turu',
                'customer_calls.conclusion as gorusme_sonucu',
                'customer_calls.gorusme_durumu as gorusme_durumu'
            )
            // ->whereNotNull('customer_calls.meet_type')
            // ->orWhereNotNull('customer_calls.conclusion')
            // ->orWhereNotNull('customer_calls.gorusme_durumu')
            ->where('danisman_id',Auth::id())
            ->get();

            $tum_musterilerCount = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->select(
                'assigned_users.*',
                'customer_calls.meet_type as gorusme_turu',
                'customer_calls.conclusion as gorusme_sonucu',
                'customer_calls.gorusme_durumu as gorusme_durumu'
            )
            // ->whereNotNull('customer_calls.meet_type')
            // ->orWhereNotNull('customer_calls.conclusion')
            // ->orWhereNotNull('customer_calls.gorusme_durumu')
            ->where('danisman_id',Auth::id())
            ->count();   

//    print_r($tum_musterilerCount);die;
      
        $favoriteCustomers = DB::table('favorite_customers')
           ->where('favorite_customers.danisman_id', Auth::id())
           ->join('assigned_users', 'favorite_customers.customer_id', '=', 'assigned_users.id')
           ->select('assigned_users.*')
           ->get();

        $favoriteCustomerCount = DB::table('favorite_customers')
        ->where('favorite_customers.danisman_id', Auth::id())
        ->join('assigned_users', 'favorite_customers.customer_id', '=', 'assigned_users.id')
        ->select('assigned_users.*')
        ->count();

          // Get the current date
         $currentDate = now()->toDateString();
        // Fetch customer IDs for appointments with 'sonraki_gorusme_turu'
        $appointmentCustomerIds = DB::table('appointments')
            ->where('sonraki_gorusme_turu','Telefon')
            ->whereDate('sonraki_gorusme_tarihi', $currentDate)
            ->pluck('customer_id')
            ->toArray();

        // Fetch customer IDs for customer calls with 'gorusme_durumu' as 'Ulaşılamadı'
        $callCustomerIds = DB::table('customer_calls')
            ->where('gorusme_durumu', 'Ulaşılamadı')
            ->where('gorusmeyi_yapan_kisi_id',Auth::id())
            ->whereDate('meeting_date', $currentDate)
            ->pluck('customer_id')
            ->toArray();

        // Combine unique customer IDs from both queries
        $uniqueCustomerIds = array_unique(array_merge($appointmentCustomerIds, $callCustomerIds));

        // Fetch customers from assigned_users table using the combined customer IDs
        $geri_donus_yapilacak_musteriler = DB::table('assigned_users')
            ->whereIn('id', $uniqueCustomerIds)
            ->get();

        $geri_donus_yapilacak_musterilerCount = DB::table('assigned_users')
            ->whereIn('id', $uniqueCustomerIds)
            ->count();   

        // $randevular = DB::table('appointments')->get();
        $today = Carbon::today()->toDateString();

        // appointments tablosundan bugünün tarihindeki randevuları say
        $randevuCount = DB::table('appointments')
            ->whereDate('appointment_date', $today)
            ->count();

         $randevular = DB::table('appointments')
            ->join('assigned_users', 'appointments.customer_id', '=', 'assigned_users.id')
            ->join('users', 'assigned_users.danisman_id', '=', 'users.id')
            ->select('appointments.*', 'users.id as danisman_id','users.name as danisman_adi')
            ->get();
          
              //danışman id ve danışman renkleri otomatik gelmeli
            // Danışman bilgilerini dinamik olarak çek
            $danismanlar = DB::table('users')
            ->join('assigned_users', 'users.id', '=', 'assigned_users.danisman_id')
            ->select('users.id', 'users.name')
            ->distinct()
            ->get();

            // Danışman renk kodları (her danışmana rastgele bir renk atanır)
            $renkler = ['#f72c00', '#00b583', '#005aff', '#ff8800', '#9b59b6', '#1abc9c', '#e74c3c', '#3498db'];
            $danismanRenkler = [];
            foreach ($danismanlar as $index => $danisman) {
                $danismanRenkler[$danisman->id] = $renkler[$index % count($renkler)];
            }
            
            $danismanProjeleri = DB::table('project_assigment')
                ->join('projects','project_assigment.project_id','projects.id')
                ->select('projects.project_title as project_title','projects.id as projectId')
                ->get();

        return view('client.panel.crm.consultantCustomerList',compact('customers','favoriteCustomers','customerCount','favoriteCustomerCount','geri_donus_yapilacak_musteriler','geri_donus_yapilacak_musterilerCount','randevular','randevuCount','danismanRenkler','danismanlar','tum_musteriler','tum_musterilerCount','danismanProjeleri'));
    }//End

    public function getMusteriBilgileri($id){
        $customer = DB::table('assigned_users')->where('id',$id)->first();
        return response()->json($customer);
    }//End

    public function musteriGecmisAramalari($id){
        $arama_kayitlari = DB::table('customer_calls')->where('customer_id',$id)->get();  
        if ($arama_kayitlari->isEmpty()) {
            return response()->json(['message' => 'Müşterinizin geçmiş arama kaydı bulunmamaktadır.']);
        }
        return response()->json($arama_kayitlari);
    }//End

    public function toggleFavorite($id){
        $userId = Auth::id();

        $favorite = DB::table('favorite_customers')
            ->where('customer_id', $id)
            ->where('danisman_id', $userId)
            ->first();

        if ($favorite) {
            // Favoriden kaldır
            DB::table('favorite_customers')
                ->where('customer_id', $id)
                ->where('danisman_id', $userId)
                ->delete();

            return response()->json(['isFavorited' => false, 'message' => 'Favoriden kaldırıldı!']);
        } else {
            // Favoriye ekle
            DB::table('favorite_customers')->insert([
                'customer_id' => $id,
                'danisman_id' => $userId,
                'created_at'  => now()
            ]);

            return response()->json(['isFavorited' => true, 'message' => 'Favoriye eklendi!']);
        }
    }//End

    public function checkFavorite($id){
        $userId = Auth::id();

        // Kullanıcının belirli bir öğeyi favoriler arasında bulunup bulunmadığını kontrol et
        $isFavorited = DB::table('favorite_customers')
            ->where('customer_id', $id)
            ->where('danisman_id', $userId)
            ->exists();

        return response()->json(['isFavorited' => $isFavorited]);
    }//End

    public function newCallCustomerInfo(Request $request){

        $musteri_guncelleme = DB::table('assigned_users')->where('id', $request->customer_id2)->update([
            'konut_tercihi'     => $request->konut_tercihi,
            'varlik_yonetimi'   => $request->varlik_yonetimi,
            'musteri_butcesi'   => $request->musterinin_butcesi,
            'ilgilendigi_bolge' => $request->ilgilendigi_bolge
        ]);

        DB::table('customer_calls')->insert([
            'customer_id'             => $request->customer_id2,
            'meet_type'               => $request->gorusme_turu,
            'gorusmeyi_yapan_kisi_id' => $request->user_id,
            'gorusme_durumu'          => $request->gorusme_durumu,
            'conclusion'              => $request->gorusme_sonucu,
            'gorusme_degerlendirme'   => $request->rating,
            'note'                    => $request->note,
            'meeting_date'            => now()

        ]);

        if($request->gorusme_sonucu == 'Randevu (Zoom)' || $request->gorusme_sonucu == 'Randevu (Yüz Yüze)' || 
           $request->sonraki_gorusme_turu == 'Randevu (Yüz Yüze)' || $request->sonraki_gorusme_turu == 'Randevu (Zoom)'){

            Appointment::create([
                'customer_id'      => $request->customer_id2,
                'appointment_date' => $request->sonraki_gorusme_tarihi,
                'appointment_info' => $request->randevu_notu,
            ]);
        }


        if($request->sonraki_gorusme_turu == 'Telefon'){
            Appointment::create([
                'customer_id'            => $request->customer_id2,
                'sonraki_gorusme_tarihi' => $request->sonraki_gorusme_tarihi,
                'sonraki_gorusme_turu'   => $request->sonraki_gorusme_turu,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Kayıt başarılı.']);

    }//End

    public function setRating(Request $request){
        // JavaScript tarafından gönderilen değeri alın
        $rating = $request->input('rating');

        return response()->json(['success' => true]);
    }//End

    public function addNewCustomer(Request $request){
        $existingCustomer = DB::table('assigned_users')
            ->where('name', $request->name)
            ->where('phone', $request->phone)
            ->first();

        // if ($existingCustomer) {
        //     return response()->json(['success' => false, 'message' => 'Bu müşteri zaten kayıtlı.']);
        // }

        if($existingCustomer){
            if($existingCustomer->project_name != $request->ilgilendigi_proje){
                $addedCustomer = DB::table('assigned_users')->insert([
                    'paremt_id'         => $existingCustomer->id,
                    'danisman_id'       => Auth::id(),
                    'name'              => $request->name,
                    'email'             => $request->email,
                    'phone'             => $request->phone,
                    'province'          => $request->province,
                    'project_name'      => $request->ilgilendigi_proje,
                    'job_title'         => $request->job_title,
                    'konut_tercihi'     => $request->konut_tercihi,
                    'varlik_yonetimi'   => $request->varlik_yonetimi,
                    'musteri_butcesi'   => $request->musteri_butcesi,
                    'ilgilendigi_bolge' => $request->ilgilendigi_bolge,
                    'created_at'        => now(),
                ]);
        
                if($addedCustomer){
                    return response()->json(['success' => true, 'message' => 'Müşteri Başarıyla eklendi']);
                }else{
                    return response()->json(['success' => false, 'message' => 'Müşteri Eklenirken hata oluştu. Lütfen tekrar deneyiniz.']);
                }
            }else{
                return response()->json(['success' => false, 'message' => 'Müşteri Eklenirken hata oluştu. Lütfen tekrar deneyiniz.']);
            }
        }else{
            $addedCustomer = DB::table('assigned_users')->insert([
                'danisman_id'       => Auth::id(),
                'name'              => $request->name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'province'          => $request->province,
                'project_name'      => $request->ilgilendigi_proje,
                'job_title'         => $request->job_title,
                'konut_tercihi'     => $request->konut_tercihi,
                'varlik_yonetimi'   => $request->varlik_yonetimi,
                'musteri_butcesi'   => $request->musteri_butcesi,
                'ilgilendigi_bolge' => $request->ilgilendigi_bolge,
                'created_at'        => now(),
            ]);

            if($addedCustomer){
                return response()->json(['success' => true, 'message' => 'Müşteri Başarıyla eklendi']);
            }else{
                return response()->json(['success' => false, 'message' => 'Müşteri Eklenirken hata oluştu. Lütfen tekrar deneyiniz.']);
            }
        }
    }//End

    public function danismanDashboard(){
$topCaller = [];
        // $totalCustomers = DB::table('assigned_users')->where('danisman_id',Auth::id())->count(); //Tüm Müşteriler
        $totalCustomers = DB::table('assigned_users')->count(); //Tüm Müşteriler

        $positiveCustomersCount = DB::table('customer_calls')
        ->join('assigned_users', 'customer_calls.customer_id', '=', 'assigned_users.id')
        ->where('danisman_id',Auth::id())
        ->where('customer_calls.gorusme_durumu', 'Olumlu')
        ->count();

        // $positiveCustomersCount = DB::table('customer_calls')
        // ->join('assigned_users', 'customer_calls.customer_id', '=', 'assigned_users.id')
        // ->where('customer_calls.gorusme_durumu', 'Olumlu')
        // ->count();

        $favoriteCustomers = DB::table('favorite_customers')->where('danisman_id',Auth::id())->count();
        // $favoriteCustomers = DB::table('favorite_customers')->count();


        //dönüş yapılacak müşteriler için danışman filtrelemesi yap canlıya alınca
        $currentDate = now()->toDateString();
      
        $appointmentCustomerIds = DB::table('appointments')
            ->whereNotNull('sonraki_gorusme_turu')
             ->whereDate('sonraki_gorusme_tarihi', $currentDate)
            ->pluck('customer_id')
            ->toArray();

        $callCustomerIds = DB::table('customer_calls')
            ->where('gorusme_durumu', 'Ulaşılamadı')
            ->whereDate('meeting_date', $currentDate)
            ->pluck('customer_id')
            ->toArray();

        $uniqueCustomerIds = array_unique(array_merge($appointmentCustomerIds, $callCustomerIds));


        $geri_donus_yapilacak_musterilerCount = DB::table('assigned_users')
        ->whereIn('id', $uniqueCustomerIds)
        ->count();   

        $danisman = DB::table('customer_calls')
            ->select('customer_calls.gorusmeyi_yapan_kisi_id', DB::raw('count(*) as total_calls'))
            ->groupBy('customer_calls.gorusmeyi_yapan_kisi_id')
            ->orderByDesc('total_calls')
            ->first();

        if ($danisman) {
            $topCaller = DB::table('users')
                ->where('id', $danisman->gorusmeyi_yapan_kisi_id)
                ->first(['name','profile_image']);

        }        

        $uniqueUserIds = DB::table('project_assigment')
        ->select('user_id')
        ->distinct()
        ->pluck('user_id');

        // $satisDanismanlari = User::whereIn('id', $uniqueUserIds)->get();
        $satisDanismanlari = User::whereIn('id', $uniqueUserIds)->get(['id', 'name', 'profile_image','code']);
          // Her danışmanın olumlu müşteri sayısını al
        $olumluMusteriSayilari = [];
        foreach ($satisDanismanlari as $item) {
            $olumluMusteriSayilari[$item->id] = DB::table('customer_calls')
                ->where('customer_calls.gorusmeyi_yapan_kisi_id', $item->id)
                ->where('customer_calls.gorusme_durumu', 'Olumlu')
                ->count();
        }

         
           $danismanVerileri = [];
           $maxSatisSayisi = 0;
           $enCokSatisYapan = null;

        foreach ($satisDanismanlari as $data) {
            $aramaSayisi = DB::table('customer_calls')
                ->where('gorusmeyi_yapan_kisi_id', $data->id)
                ->count();

            $musteriSayisi = DB::table('assigned_users')
                ->where('danisman_id', $data->id)
                ->count();

            $donusYapilanMusteri = DB::table('customer_calls')
                ->where('gorusmeyi_yapan_kisi_id', $data->id)
                ->whereDate('meeting_date', $currentDate)
                ->where('gorusme_durumu', 'Olumlu')
                ->count();

            $satisSayisi = DB::table('cart_orders')
                ->where('reference_id',$data->id)
                ->where('status','1')
                ->count();   
            
              

            $danismanVerileri[$data->id] = [
                'arama_sayisi' => $aramaSayisi,
                'musteri_sayisi' => $musteriSayisi,
                'donus_yapilan_musteri' => $donusYapilanMusteri,
                'satis_sayisi'          => $satisSayisi
            ];

            if ($satisSayisi > $maxSatisSayisi) {
                $maxSatisSayisi = $satisSayisi;
                $enCokSatisYapan = $data;
                $enCokSatisYapan->satis_sayisi = $satisSayisi;
            }
        }


        $danismanSatislari = DB::table('cart_orders')
            ->where('reference_id', Auth::id())
            ->where('status', '1')
            ->orderBy('created_at', 'asc')
            ->get();

            
        
        $currentMonth = null;
        $komisyonIndex = 0;
        $totalKazanc = 0;
        $satisKazanc = [];

        $pesinSatislar = [];
        $taksitliSatislar = [];

        $pesinSatisSayisi = 0;
        $taksitliSatisSayisi = 0;
        
        foreach ($danismanSatislari as $satis) {
            $cart = json_decode($satis->cart);

            if ($satis->is_swap == 0) {
                $pesinSatislar[] = $satis;
                $pesinSatisSayisi++;
            } else {
                $taksitliSatislar[] = $satis;
                $taksitliSatisSayisi++;
            }

            if($satis->is_swap == 0){
                $price = $cart->item->price;
                $satisMonth = Carbon::parse($satis->created_at)->format('Y-m');
            
                if ($currentMonth !== $satisMonth) {
                    $currentMonth = $satisMonth;
                    $komisyonIndex = 0;
                }
            
                if ($komisyonIndex == 0) {
                    $komisyon = 0.005;
                } elseif ($komisyonIndex == 1) {
                    $komisyon = 0.007;
                } elseif ($komisyonIndex == 2) {
                    $komisyon = 0.01;
                } else {
                    $komisyon = 0.02;
                }
            
                $kazanc = $price * $komisyon;
                $totalKazanc += $kazanc;
                $satisKazanc[$satis->id] = $kazanc;
                $komisyonIndex++;
            }else{
                $price = $cart->item->pesinat;
                $satisMonth = Carbon::parse($satis->created_at)->format('Y-m');
            
                if ($currentMonth !== $satisMonth) {
                    $currentMonth = $satisMonth;
                    $komisyonIndex = 0;
                }
            
                if ($komisyonIndex == 0) {
                    $komisyon = 0.005;
                } elseif ($komisyonIndex == 1) {
                    $komisyon = 0.007;
                } elseif ($komisyonIndex == 2) {
                    $komisyon = 0.01;
                } else {
                    $komisyon = 0.02;
                }
            
                $kazanc = $price * $komisyon;
                $totalKazanc += $kazanc;
                $satisKazanc[$satis->id] = $kazanc;
                $komisyonIndex++;
            }          
        }

        $awards = Award::latest()->take(3)->get();        

        return view('client.panel.crm.danisman_dashboard', compact('totalCustomers','positiveCustomersCount','favoriteCustomers',
            'geri_donus_yapilacak_musterilerCount','topCaller','danisman','satisDanismanlari', 'olumluMusteriSayilari','danismanVerileri','enCokSatisYapan',
            'danismanSatislari','awards','satisKazanc','totalKazanc','taksitliSatisSayisi','pesinSatisSayisi'));
    }//End

    public function adminDashboard(){

        $totalCustomers = DB::table('assigned_users')->count(); //Tüm Müşteriler

        $positiveCustomersCount = DB::table('customer_calls')
        ->join('assigned_users', 'customer_calls.customer_id', '=', 'assigned_users.id')
        ->where('customer_calls.gorusme_durumu', 'Olumlu')
        ->count();

        $favoriteCustomers = DB::table('favorite_customers')->count();

        $currentDate = now()->toDateString();
        // Fetch customer IDs for appointments with 'sonraki_gorusme_turu'
        $appointmentCustomerIds = DB::table('appointments')
            ->whereNotNull('sonraki_gorusme_turu')
            // ->whereDate('sonraki_gorusme_tarihi', $currentDate)
            ->pluck('customer_id')
            ->toArray();

        // Fetch customer IDs for customer calls with 'gorusme_durumu' as 'Ulaşılamadı'
        $callCustomerIds = DB::table('customer_calls')
            ->where('gorusme_durumu', 'Ulaşılamadı')
            ->whereDate('meeting_date', $currentDate)
            ->pluck('customer_id')
            ->toArray();

        $uniqueCustomerIds = array_unique(array_merge($appointmentCustomerIds, $callCustomerIds));

        $geri_donus_yapilacak_musterilerCount = DB::table('assigned_users')
        ->whereIn('id', $uniqueCustomerIds)
        ->count();   


        $danisman = DB::table('customer_calls')
        ->select('customer_calls.gorusmeyi_yapan_kisi_id', DB::raw('count(*) as total_calls'))
        ->groupBy('customer_calls.gorusmeyi_yapan_kisi_id')
        ->orderByDesc('total_calls')
        ->first();

        if ($danisman) {
            $topCaller = DB::table('users')
                ->where('id', $danisman->gorusmeyi_yapan_kisi_id)
                ->first(['name','profile_image']);
        }        
        // print_r($topCaller);die;

        $uniqueUserIds = DB::table('project_assigment')
        ->select('user_id')
        ->distinct()
        ->pluck('user_id');

        $satisDanismanlari = User::whereIn('id', $uniqueUserIds)->get();

          // Her danışmanın olumlu müşteri sayısını al
            $olumluMusteriSayilari = [];
            foreach ($satisDanismanlari as $item) {
                $olumluMusteriSayilari[$item->id] = DB::table('customer_calls')
                    ->where('customer_calls.gorusmeyi_yapan_kisi_id', $item->id)
                    ->where('customer_calls.gorusme_durumu', 'Olumlu')
                    ->count();
            }

            // Her danışmanın arama sayısı, müşteri sayısı ve dönüş yapılan müşteri sayısını al
            $danismanVerileri = [];
            $maxSatisSayisi = 0;
            $enCokSatisYapan = null;

            foreach ($satisDanismanlari as $data) {
                $aramaSayisi = DB::table('customer_calls')
                    ->where('gorusmeyi_yapan_kisi_id', $data->id)
                    ->count();

                $musteriSayisi = DB::table('assigned_users')
                    ->where('danisman_id', $data->id)
                    ->count();

                $donusYapilanMusteri = DB::table('customer_calls')
                    ->where('gorusmeyi_yapan_kisi_id', $data->id)
                    ->whereDate('meeting_date', $currentDate)
                    ->where('gorusme_durumu', 'Olumlu')
                    ->count();

                $satisSayisi = DB::table('cart_orders')
                    ->where('reference_id',$data->id)
                    ->where('status','1')
                    ->count();  

                $satisDetaylari = DB::table('cart_orders')
                    ->where('reference_id', $data->id)
                    ->where('status','1')
                    ->get();  

                $danismanVerileri[$data->id] = [
                    'arama_sayisi'          => $aramaSayisi,
                    'musteri_sayisi'        => $musteriSayisi,
                    'donus_yapilan_musteri' => $donusYapilanMusteri,
                    'satis_sayisi'          => $satisSayisi,
                    'satis_detaylari'       => $satisDetaylari
                ];

                if ($satisSayisi > $maxSatisSayisi) {
                    $maxSatisSayisi = $satisSayisi;
                    $enCokSatisYapan = $data;
                    $enCokSatisYapan->satis_sayisi = $satisSayisi;
                }

            }    


    $bireysel_satislar = DB::table('cart_orders')->whereNull('reference_id')->where('status','1')->count();

    $danismanlarin_toplam_satis_sayisi = DB::table('cart_orders')->whereNotNull('reference_id')->where('status','1')->count();

    $sirket_satis_sayisi = $bireysel_satislar + $danismanlarin_toplam_satis_sayisi;

    $sharerIndividualCount = CartOrder::join('sharer_prices','sharer_prices.cart_id','=','cart_orders.id')
        ->join('users','users.id','=','sharer_prices.user_id')->where('users.type',1)->count();

    $sharerEstateCount =     CartOrder::join('sharer_prices','sharer_prices.cart_id','=','cart_orders.id')
        ->join('users','users.id','=','sharer_prices.user_id')->where('users.type','!=',1)->count();
    

    $labels = ['Emlak Kulüp Aracılığıyla Satış', 'Emlak Firmaları Aracılığıyla Satış', 'Şirket Satış'];
    $satis_sayilari = [$sharerIndividualCount, $sharerEstateCount, $sirket_satis_sayisi];

    $awards = Award::latest()->take(3)->get();

        return view('client.panel.crm.admin_dashboard', compact('labels','totalCustomers','positiveCustomersCount','favoriteCustomers','geri_donus_yapilacak_musterilerCount',
            'topCaller','danisman','satisDanismanlari','olumluMusteriSayilari','danismanVerileri','enCokSatisYapan','bireysel_satislar','danismanlarin_toplam_satis_sayisi'
            ,'sirket_satis_sayisi','satis_sayilari','labels','awards','sharerIndividualCount','sharerEstateCount'));
    }//End

    public function adminOdulEkle(){
        $awards = Award::orderBy('created_at', 'desc')->get();

        return view('client.panel.crm.admin_odul_ekle',compact('awards'));
    }//End

    public function adminOdulEklePost(Request $request){

        $request->validate([
            'award_image' => 'nullable|file|mimes:png',
            'title' => 'required|string|max:255',
            'award_name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ], [
            'award_image.mimes' => 'Yalnızca PNG formatında dosyalar kabul edilmektedir.'
        ]);
    
       
           // Ödül resminin yüklendiği kısmı kontrol edin ve saklayın
           if ($request->hasFile('award_image')) {
                $image = $request->file('award_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('awards'), $imageName);
            } else {
                $imageName = 'default_award.png'; // Varsayılan resim dosyası
            }
     
            // Veritabanına kaydetme işlemi
            $award = new Award();
            $award->award_image     = $imageName;
            $award->title           = $request->input('title');
            $award->award_name      = $request->input('award_name');
            $award->status          = $request->has('status');
            $award->ekleyen_user_id = Auth::id();
            $award->created_at      = now();
            $award->updated_at      = now();
            $award->save();            

            return redirect()->back()->with('success','Ödül Başarıyla Eklendi.');
    }//End

    public function awardEdit($id){
        $award = Award::findOrFail($id);
        return response()->json($award);
    }//End

    public function awardUpdate(Request $request, $id){
        $award = Award::findOrFail($id);
        
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'award_name' => 'required|string|max:255',
            'award_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Update fields
        $award->title = $request->input('title');
        $award->award_name = $request->input('award_name');
        $award->status = $request->has('status') ? 1 : 0;

        // Handle file upload
        if ($request->hasFile('award_image')) {
            $imagePath = $request->file('award_image')->store('award_images', 'public');
            $award->award_image = $imagePath;
        }

        $award->save();

        return response()->json(['message' => 'Ödül başarıyla güncellendi']);
    }//End
}
