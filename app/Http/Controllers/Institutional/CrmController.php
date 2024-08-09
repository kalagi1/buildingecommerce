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
        $projects = Project::where('status', '1')->where('user_id', Auth::user()->id )->get();
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

    public function assignProjectUser(Request $request) {
        $userId = $request->user_id;
        $projectIds = $request->projectIds;
    
        // Önce, kullanıcının mevcut proje atamalarını temizle
        DB::table('project_assigment')->where('user_id', $userId)->delete();
    
        // Ardından, seçilen projeleri ekle
        if (!empty($projectIds)) {
            foreach ($projectIds as $projectId) {
                DB::table('project_assigment')->insert([
                    'user_id'    => $userId,
                    'project_id' => $projectId,
                    'created_at' => now()
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Değişiklikler başarıyla gerçekleşti.');
    }//End
    

    public function consultantCustomerList(){
        // $customers = DB::table('assigned_users')->where('danisman_id',Auth::id())->get(); // Yeni Müşteriler //arama kaydı olmayanları listele sorguyu güncelle

        // $tum_musteriler = DB::table('assigned_users')

        // $customers = DB::table('assigned_users')->get(); //Tüm Müşteriler

        $customers = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->whereNull('customer_calls.customer_id')
            ->where('danisman_id',Auth::id())
            ->select('assigned_users.*')
            ->get();
            $customerCount = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->whereNull('customer_calls.customer_id')
            ->where('danisman_id',Auth::id())
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
            'meeting_date'            => now(),
            'created_at'              =>now()   

        ]);

        if($request->gorusme_sonucu == 'Randevu (Zoom)' || $request->gorusme_sonucu == 'Randevu (Yüz Yüze)' || 
           $request->sonraki_gorusme_turu == 'Randevu (Yüz Yüze)' || $request->sonraki_gorusme_turu == 'Randevu (Zoom)'){

            Appointment::create([
                'customer_id'      => $request->customer_id2,
                'danisman_id'      => Auth::id(),
                'appointment_date' => $request->sonraki_gorusme_tarihi,
                'appointment_info' => $request->randevu_notu,
            ]);
        }


        if($request->sonraki_gorusme_turu == 'Telefon'){
            Appointment::create([
                'customer_id'            => $request->customer_id2,
                'danisman_id'      => Auth::id(),
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

        $topCaller = [];
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


    $bireysel_satislar                 = DB::table('cart_orders')->whereNull('reference_id')->where('store_id',Auth::id())->where('status','1')->count();
    $danismanlarin_toplam_satis_sayisi = DB::table('cart_orders')->whereNotNull('reference_id')->where('store_id',Auth::id())->where('status','1')->count();

    $sirket_satis_sayisi = $bireysel_satislar + $danismanlarin_toplam_satis_sayisi;
    // print_r($sirket_satis_sayisi);die;

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

    public function updateTodayWorking(Request $request) {
        $userId = $request->input('user_id');
        $todayWorking = $request->input('today_working');
    
        // Veritabanında güncelleme yap
        // DB::table('users')
        //     ->where('id', $userId)
        //     ->update(['today_working' => $todayWorking]);

        $user = User::find($userId);
        $user->today_working = $todayWorking;
        $user->save();
    
        return response()->json(['status' => 'success']);
    }//End

    public function raporlarim(){

        $parentId = Auth::id();

        $consultantDailyAppointments  = $this->consultantDailyAppointments();
        $consultantWeeklyAppointments = $this->consultantWeeklyAppointments();
        $consultantMonthlyAppointments = $this->consultantMonthlyAppointments();

        $housingPreferences      = $this->housingPreferences();
        $assetManagements        = $this->assetManagements();
        $budgetCounts            = $this->budgetCounts();
        $regionCounts            = $this->regionCounts($parentId);
        $consultantCalls         = $this->consultantCalls();
        $getDailyCallCounts      = $this->getDailyCallCounts();
        $getWeeklyCallCounts     = $this->getWeeklyCallCounts();
        $getMonthlyCallCounts    = $this->getMonthlyCallCounts();
        $getCallConclusions      = $this->getCallConclusions();
        $getCallCustomerStatus   = $this->getCallCustomerStatus();

        $salesDetails             = $this->getSalesDetailsForConsultants($parentId);
        $monthlySalesDetails      = $this->getMonthlySalesForConsultants($parentId);

        $getDailyCustomerStatuses = $this->getDailyCustomerStatuses();  //günlük genel müşteri durumu istatistiği
        $getWeeklyCustomerStatus  = $this->getWeeklyCustomerStatus();   //günlük genel müşteri durumu istatistiği
        $getMonthlyCustomerStatus = $this->getMonthlyCustomerStatus();  //günlük genel müşteri durumu istatistiği

         $getDailyCustomerCallResults  = $this->getDailyCustomerCallResults();    //günlük genel görüşme sonucu istatistiği
         $getWeeklyCustomerCallResults = $this->getWeeklyCustomerCallResults();   //haftalık genel görüşme sonucu istatistiği
         $getMonthlyCustomerCallResults = $this->getMonthlyCustomerCallResults(); //aylık genel görüşme sonucu istatistiği

         $getConsultantSales = $this->getConsultantSales();
         $sourcePlatform = $this->sourcePlatform();
            //  dd($sourcePlatform);

        return view('client.panel.crm.raporlarim', compact('housingPreferences','assetManagements',
        'budgetCounts','regionCounts','consultantCalls','getDailyCallCounts','getWeeklyCallCounts','getMonthlyCallCounts',
        'getCallConclusions','getCallCustomerStatus','salesDetails','monthlySalesDetails','getDailyCustomerStatuses',
        'getWeeklyCustomerStatus','getMonthlyCustomerStatus','getDailyCustomerCallResults','getWeeklyCustomerCallResults',
        'getMonthlyCustomerCallResults','getConsultantSales','consultantDailyAppointments','consultantWeeklyAppointments',
         'consultantMonthlyAppointments','sourcePlatform'       
        ));
    }//End

    //Raporlarim sayfası için fonksiyonlar
    
    private function consultantDailyAppointments() { //günlük danışmanlar ve randevu sayıları (bilgileri)
        $today = Carbon::now()->startOfDay();

        $consultantDailyAppointments = Appointment::with('consultant')
        ->select('danisman_id', DB::raw('COUNT(*) as appointment_count'))
        ->whereDate('appointment_date', $today)
        ->groupBy('danisman_id')
        ->get()
        ->map(function ($item) {
            // Eğer consultant ilişkisi null ise boş bir değer döndür
            return [
                'representative_name' => $item->consultant ? $item->consultant->name : 'Bilinmiyor',
                'appointment_count' => $item->appointment_count,
            ];
        });
        return $consultantDailyAppointments;
    }//End

    private function consultantWeeklyAppointments() { //haftalık danışmanlar ve randevu sayıları (bilgileri)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $consultantWeeklyAppointments = Appointment::with('consultant')
        ->select('danisman_id', DB::raw('COUNT(*) as appointment_count'))
        ->whereBetween('appointment_date', [$startOfWeek, $endOfWeek])
        ->groupBy('danisman_id')
        ->get()
        ->map(function ($item) {
            // Eğer consultant ilişkisi null ise boş bir değer döndür
            return [
                'representative_name' => $item->consultant ? $item->consultant->name : 'Bilinmiyor',
                'appointment_count' => $item->appointment_count,
            ];
        });
        return $consultantWeeklyAppointments;
    }//End
    
    private function consultantMonthlyAppointments() { //aylık danışmanlar ve randevu sayıları (bilgileri)
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $consultantMonthlyAppointments = Appointment::with('consultant')
        ->select('danisman_id', DB::raw('COUNT(*) as appointment_count'))
        ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
        ->groupBy('danisman_id')
        ->get()
        ->map(function ($item) {
            // Eğer consultant ilişkisi null ise boş bir değer döndür
            return [
                'representative_name' => $item->consultant ? $item->consultant->name : 'Bilinmiyor',
                'appointment_count' => $item->appointment_count,
            ];
        });
        return $consultantMonthlyAppointments;
    }//End

    private function housingPreferences(){   // Konut tercihi seçenekleri için müşteri sayıları
        $housingPreferences = DB::table('assigned_users')
        ->select('konut_tercihi', DB::raw('COUNT(*) as total'))
        ->whereIn('konut_tercihi', ['Projeden Konut', 'Hazır Konut','Arsa'])
        ->groupBy('konut_tercihi')
        ->get();
        return $housingPreferences;
    }//End

    private function assetManagements(){    // Varlık yönetimi seçenekleri için müşteri sayıları
        $assetManagements = DB::table('assigned_users')
        ->select('varlik_yonetimi', DB::raw('COUNT(*) as total'))
        ->whereIn('varlik_yonetimi', ['Yatırım', 'Oturum', 'Yatırım/Oturum'])
        ->groupBy('varlik_yonetimi')
        ->get();
        return $assetManagements;
    }//End

    private function budgetCounts(){   // Müşteri bütçesi seçenekleri için müşteri sayıları
        $budgetCounts = DB::table('assigned_users')
        ->select('musteri_butcesi', DB::raw('COUNT(*) as total'))
        ->whereNotNull('musteri_butcesi')
        ->groupBy('musteri_butcesi')
        ->orderBy('total', 'desc') // En yüksek total değerine göre sırala
        ->limit(3)
        ->get();
        return $budgetCounts;
    }//End

    private function regionCounts($parentId){  // İlgilendiği bölge seçenekleri için müşteri sayıları
      
        $projects = Project::where('user_id', $parentId)
        // ->where('status','1')
        ->get();

         // Veriyi JSON formatında Blade'e gönderiyoruz
        $regionCounts = $projects->map(function($project) {
            list($latitude, $longitude) = explode(',', $project->location);
            return [
                'name'             => $project->project_title,
                'description'      => $project->description,
                'step1_slug'       => $project->step1_slug,
                'step2_slug'       => $project->step2_slug,
                'view_count'       => $project->view_count,
                'room_count'       => $project->room_count,
                'start_date'       => $project->start_date,
                'project_end_date' => $project->project_end_date,
                'latitude'         => trim($latitude),
                'longitude'        => trim($longitude)
            ];

        });

        return $regionCounts;
    }//End

    private function consultantCalls(){  // Danışmanlar ve görüşmeler bilgilerini tek bir sorguda getir
        $consultantCalls = DB::table('customer_calls')
        ->join('users', 'customer_calls.gorusmeyi_yapan_kisi_id', '=', 'users.id')
        ->select(
            'customer_calls.id as call_id',
            'customer_calls.note',
            'customer_calls.conclusion',
            'customer_calls.meet_type',
            'customer_calls.gorusme_durumu',
            'users.id as consultant_id',
            'users.name as consultant_name',
            'users.email as consultant_email',
            // DB::raw('COUNT(customer_calls.id) as call_count'),
        )
        // ->groupBy('users.id', 'users.name', 'users.email')
        ->get();

        return $consultantCalls;
    }//End

    private function getDailyCallCounts(){ //Danışmanların günlük arama sayıları
        $today = Carbon::now()->startOfDay();
        return DB::table('customer_calls')
        ->join('users', 'customer_calls.gorusmeyi_yapan_kisi_id', '=', 'users.id')
        ->select('users.id as consultant_id', 'users.name as consultant_name', DB::raw('COUNT(*) as total'))
        ->whereDate('customer_calls.created_at', $today)
        ->groupBy('users.id', 'users.name')
        ->get();
    }//End
    private function getWeeklyCallCounts() { // Danışmanların haftalık arama sayıları
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        return DB::table('customer_calls')
            ->join('users', 'customer_calls.gorusmeyi_yapan_kisi_id', '=', 'users.id')
            ->select('users.id as consultant_id', 'users.name as consultant_name', DB::raw('COUNT(*) as total'))
            ->whereBetween('customer_calls.created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('users.id', 'users.name')
            ->get();
    }//End
    
    private function getMonthlyCallCounts() { // Danışmanların aylık arama sayıları
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        return DB::table('customer_calls')
            ->join('users', 'customer_calls.gorusmeyi_yapan_kisi_id', '=', 'users.id')
            ->select('users.id as consultant_id', 'users.name as consultant_name', DB::raw('COUNT(*) as total'))
            ->whereBetween('customer_calls.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('users.id', 'users.name')
            ->get();
    }//End

    private function getCallConclusions(){ // Görüşme sonuçlarını gruplandırarak ve sayarak döndür (RANDEVU)
    return   DB::table('customer_calls')
                ->join('users', 'customer_calls.gorusmeyi_yapan_kisi_id', '=', 'users.id')
                ->select(
                    'users.id as consultant_id',
                    'users.name as consultant_name',
                    'customer_calls.conclusion',
                    DB::raw('COUNT(*) as total')
                )
                ->whereIn('customer_calls.conclusion', ['Randevu (Telefon)', 'Randevu (Yüz Yüze)'])
                ->groupBy('users.id', 'users.name', 'customer_calls.conclusion')
                ->get();
    }//End

    private function getCallCustomerStatus(){ // Müşteri durumlarını olumlu gruplandırarak ve sayarak döndür (OLUMLU)
        return   DB::table('customer_calls')
        ->join('users', 'customer_calls.gorusmeyi_yapan_kisi_id', '=', 'users.id')
        ->select(
            'users.id as consultant_id',
            'users.name as consultant_name',
            'customer_calls.gorusme_durumu',
            DB::raw('COUNT(*) as total')
        )
        ->where('customer_calls.gorusme_durumu','Olumlu')
        ->groupBy('users.id', 'users.name', 'customer_calls.gorusme_durumu')
        ->get();
    }//End

    private function getSalesDetailsForConsultants($parentId){ // Danışmanlar ve yaptıkları satışlar
        return DB::table('cart_orders')
            ->join('users', 'cart_orders.reference_id', '=', 'users.id')
            ->select(
                'users.id as consultant_id',
                'users.name as consultant_name',
                'cart_orders.id as order_id',
                'cart_orders.created_at',
                'cart_orders.amount'
            )
            ->where('users.parent_id', $parentId)
            ->where('cart_orders.status','1')
            ->get();
    }//End

    private function getMonthlySalesForConsultants($parentId){ //Danışmanların ay bazlı satış verileri
        return DB::table('cart_orders')
            ->join('users', 'cart_orders.reference_id', '=', 'users.id')
            ->select(
                'users.id as consultant_id',
                'users.name as consultant_name',
                DB::raw('MONTH(cart_orders.created_at) as month'),
                DB::raw('YEAR(cart_orders.created_at) as year'),
                DB::raw('COUNT(cart_orders.id) as total_sales'),
                DB::raw('SUM(cart_orders.amount) as total_amount')
            )
            ->where('users.parent_id', $parentId)
            ->groupBy('users.id', 'users.name', DB::raw('MONTH(cart_orders.created_at)'), DB::raw('YEAR(cart_orders.created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }//End

    private function getDailyCustomerStatuses() { //günlük genel müşteri durum istatistiği
        $statuses = [
            'Olumsuz',
            'Ulaşılamadı',
            'Hatalı Numara',
            'Nötr',
            'Olumlu',
            'Sıcak Müşteri',
            'Opsiyon'
        ];
    
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();
 
        $getDailyCustomerStatuses = DB::table('customer_calls')
            ->select('gorusme_durumu', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startOfDay, $endOfDay]) 
            ->whereIn('gorusme_durumu', $statuses)
            ->groupBy('gorusme_durumu')
            ->get()
            ->keyBy('gorusme_durumu'); // Durumları anahtar olarak kullan
  
        // Durumları eksiksiz bir şekilde döndürmek için varsayılan değerler ekle
        foreach ($statuses as $status) {
            if (!isset($getDailyCustomerStatuses[$status])) {
                $getDailyCustomerStatuses[$status] = (object) ['total' => 0];
            }
        }
    
        return $getDailyCustomerStatuses;
    }//End    

    private function getWeeklyCustomerStatus() {  //haftalık genel müşteri durum istatistiği
        $statuses = [
            'Olumsuz',
            'Ulaşılamadı',
            'Hatalı Numara',
            'Nötr',
            'Olumlu',
            'Sıcak Müşteri',
            'Opsiyon'
        ];
    
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
    
        $getWeeklyCustomerStatus = DB::table('customer_calls')
            ->select('gorusme_durumu', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Haftalık tarih aralığı
            ->whereIn('gorusme_durumu', $statuses)
            ->groupBy('gorusme_durumu')
            ->get()
            ->keyBy('gorusme_durumu');
    
        foreach ($statuses as $status) {
            if (!isset($getWeeklyCustomerStatus[$status])) {
                $getWeeklyCustomerStatus[$status] = (object) ['total' => 0];
            }
        }
    
        return $getWeeklyCustomerStatus;
    }//End
    
    private function getMonthlyCustomerStatus() {  //aylık genel müşteri durum istatistiği
        $statuses = [
            'Olumsuz',
            'Ulaşılamadı',
            'Hatalı Numara',
            'Nötr',
            'Olumlu',
            'Sıcak Müşteri',
            'Opsiyon'
        ];
    
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        $getMonthlyCustomerStatus = DB::table('customer_calls')
            ->select('gorusme_durumu', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) // Aylık tarih aralığı
            ->whereIn('gorusme_durumu', $statuses)
            ->groupBy('gorusme_durumu')
            ->get()
            ->keyBy('gorusme_durumu');
    
        foreach ($statuses as $status) {
            if (!isset($getMonthlyCustomerStatus[$status])) {
                $getMonthlyCustomerStatus[$status] = (object) ['total' => 0];
            }
        }
    
        return $getMonthlyCustomerStatus;
    }//End
    
    private function getDailyCustomerCallResults() { //günlük genel görüşme sonucu istatistiği
        $statuses = [
            'Takip Edilecek',
            'Randevu (Zoom)',
            'Randevu (Yüz Yüze)',
            'Yeni Projelerde Aranacak',
            'Olumsuz',
            'Bir Daha Aranmayacak',
            'Satış'
        ];
    
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();
 
        $getDailyCustomerCallResults = DB::table('customer_calls')
            ->select('conclusion', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startOfDay, $endOfDay]) 
            ->whereIn('conclusion', $statuses)
            ->groupBy('conclusion')
            ->get()
            ->keyBy('conclusion'); // Durumları anahtar olarak kullan
  
        // Durumları eksiksiz bir şekilde döndürmek için varsayılan değerler ekle
        foreach ($statuses as $status) {
            if (!isset($getDailyCustomerCallResults[$status])) {
                $getDailyCustomerCallResults[$status] = (object) ['total' => 0];
            }
        }
    
        return $getDailyCustomerCallResults;
    }//End  

    private function getWeeklyCustomerCallResults() {  //haftalık genel görüşme sonucu istatistiği
        $statuses = [
            'Takip Edilecek',
            'Randevu (Zoom)',
            'Randevu (Yüz Yüze)',
            'Yeni Projelerde Aranacak',
            'Olumsuz',
            'Bir Daha Aranmayacak',
            'Satış'
        ];
    
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
    
        $getWeeklyCustomerCallResults = DB::table('customer_calls')
            ->select('conclusion', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek]) // Haftalık tarih aralığı
            ->whereIn('conclusion', $statuses)
            ->groupBy('conclusion')
            ->get()
            ->keyBy('conclusion');
    
        foreach ($statuses as $status) {
            if (!isset($getWeeklyCustomerCallResults[$status])) {
                $getWeeklyCustomerCallResults[$status] = (object) ['total' => 0];
            }
        }
    
        return $getWeeklyCustomerCallResults;
    }//End
    
    private function getMonthlyCustomerCallResults() {  //aylık genel görüşme sonucu istatistiği
        $statuses = [
            'Takip Edilecek',
            'Randevu (Zoom)',
            'Randevu (Yüz Yüze)',
            'Yeni Projelerde Aranacak',
            'Olumsuz',
            'Bir Daha Aranmayacak',
            'Satış'
        ];
    
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        $getMonthlyCustomerCallResults = DB::table('customer_calls')
            ->select('conclusion', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) // Aylık tarih aralığı
            ->whereIn('conclusion', $statuses)
            ->groupBy('conclusion')
            ->get()
            ->keyBy('conclusion');
    
        foreach ($statuses as $status) {
            if (!isset($getMonthlyCustomerCallResults[$status])) {
                $getMonthlyCustomerCallResults[$status] = (object) ['total' => 0];
            }
        }
    
        return $getMonthlyCustomerCallResults;
    }//End

    private function getConsultantSales(){ //satış temsilcilerimin yaptıgı satış türleri
          // Temsilcilerin ID'lerini al
            $representativeIds = DB::table('users')
            ->where('parent_id', Auth::id())
            ->pluck('id');

        // Satış verilerini al
        $sales = DB::table('cart_orders')
            ->whereIn('reference_id', $representativeIds)
            ->get();

        // Satışları temsilcilere göre grupla ve konut, iş yeri ve arsa satışlarının sayısını hesapla
        $salesSummary = [];

        foreach ($sales as $sale) {
            $cart = json_decode($sale->cart, true);

            if ($cart && isset($cart['type'], $cart['item']['id'])) {
                $type = $cart['type'];
                $itemId = $cart['item']['id'];

                // Item'ın türünü al
                if ($type === 'housing') {
                    $item = DB::table('housings')
                        ->where('id', $itemId)
                        ->first();
                    $slug = $item ? $item->step1_slug : 'N/A';
                } elseif ($type === 'project') {
                    $item = DB::table('projects')
                        ->where('id', $itemId)
                        ->first();
                    $slug = $item ? $item->step1_slug : 'N/A';
                } else {
                    continue; // Diğer türler için işleme devam etme
                }

                // Satış temsilcisinin adı
                $representativeName = DB::table('users')
                    ->where('id', $sale->reference_id)
                    ->value('name');

                // Satış temsilcisi ve satış türlerini ekle
                if (!isset($salesSummary[$sale->reference_id])) {
                    $salesSummary[$sale->reference_id] = [
                        'representative_name' => $representativeName,
                        'konut' => 0,
                        'is-yeri' => 0,
                        'arsa' => 0,
                    ];
                }

                // Türüne göre satış sayısını artır
                if ($slug === 'konut') {
                    $salesSummary[$sale->reference_id]['konut'] += 1;
                } elseif ($slug === 'is-yeri') {
                    $salesSummary[$sale->reference_id]['is-yeri'] += 1;
                } elseif ($slug === 'arsa') {
                    $salesSummary[$sale->reference_id]['arsa'] += 1;
                }
            }
        }

        return $salesSummary;
    }//End

    private function sourcePlatform()
    {
        // `assigned_users` tablosundaki tüm platform verilerini al
        $platforms = AssignedUser::pluck('platform')->toArray();
    
        // Platformları saymak için bir dizi oluştur
        $platformCounts = array_count_values($platforms);
    
        // Toplam sayıyı hesapla
        $totalCount = array_sum($platformCounts);
    
        // Oranları hesapla ve sonuçları formatla
        $platformPercentages = [];
        foreach ($platformCounts as $platform => $count) {
            $percentage = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;
            $platformPercentages[$platform] = [
                'count' => $count,
                'percentage' => number_format($percentage, 2) // İki ondalık basamağa yuvarla
            ];
        }
    
        // 'ig' ve 'fb' yerine 'Instagram' ve 'Facebook' kullanarak platform adlarını değiştirme
        $platformPercentagesFormatted = [
            'Instagram' => $platformPercentages['ig'] ?? ['count' => 0, 'percentage' => 0],
            'Facebook' => $platformPercentages['fb'] ?? ['count' => 0, 'percentage' => 0]
        ];
    
        return [
            'platformData' => $platformPercentagesFormatted,
            'totalCount' => $totalCount
        ];
    }
    
}
