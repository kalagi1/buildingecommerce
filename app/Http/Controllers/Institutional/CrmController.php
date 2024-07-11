<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AssignedUser;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    public function index(){
        return view('client.panel.crm.index');
    }

    public function projectAssigment(){
        return view('client.panel.crm.project_assigment');
    }//End

    public function salesConsultantList(){
        $sales_consultant = User::where('project_authority','on')->get(); 
        $projects = Project::where('status','1')->get();
        // print_r(count($projects));die;
        return view('client.panel.sales_consultant.index',compact('sales_consultant','projects'));
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

        $customers = DB::table('assigned_users')->get(); //Tüm Müşteriler

        $tum_musteriler = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->select(
                'assigned_users.*',
                'customer_calls.meet_type as gorusme_turu',
                'customer_calls.conclusion as gorusme_sonucu',
                'customer_calls.gorusme_durumu as gorusme_durumu'
            )
            ->whereNotNull('customer_calls.meet_type')
            ->orWhereNotNull('customer_calls.conclusion')
            ->orWhereNotNull('customer_calls.gorusme_durumu')
            // ->where('danisman_id',Auth::id())
            ->get();


            $tum_musterilerCount = DB::table('assigned_users')
            ->leftJoin('customer_calls', 'assigned_users.id', '=', 'customer_calls.customer_id')
            ->select(
                'assigned_users.*',
                'customer_calls.meet_type as gorusme_turu',
                'customer_calls.conclusion as gorusme_sonucu',
                'customer_calls.gorusme_durumu as gorusme_durumu'
            )
            ->whereNotNull('customer_calls.meet_type')
            ->orWhereNotNull('customer_calls.conclusion')
            ->orWhereNotNull('customer_calls.gorusme_durumu')
            // ->where('danisman_id',Auth::id())
            ->count();   
        $customerCount = DB::table('assigned_users')->count(); //Tüm Müşteriler
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

        // Combine unique customer IDs from both queries
        $uniqueCustomerIds = array_unique(array_merge($appointmentCustomerIds, $callCustomerIds));

        // print_r($uniqueCustomerIds);die;

        // Fetch customers from assigned_users table using the combined customer IDs
        $geri_donus_yapilacak_musteriler = DB::table('assigned_users')
            ->whereIn('id', $uniqueCustomerIds)
            ->get();

        $geri_donus_yapilacak_musterilerCount = DB::table('assigned_users')
        ->whereIn('id', $uniqueCustomerIds)
        ->count();

    

        // $randevular = DB::table('appointments')->get();
        // Bugünün tarihini al
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

        return view('client.panel.crm.consultantCustomerList',compact('customers','favoriteCustomers','customerCount','favoriteCustomerCount','geri_donus_yapilacak_musteriler','geri_donus_yapilacak_musterilerCount','randevular','randevuCount','danismanRenkler','danismanlar','tum_musteriler','tum_musterilerCount'));
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

        Appointment::create([
            'customer_id'      => $request->customer_id2,
            'appointment_date' => $request->randevu_tarihi,
            'appointment_info' => $request->randevu_notu,
        ]);

        if($request->sonraki_gorusme_tarihi && $request->sonraki_gorusme_turu){
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
        // print_r($request->all());die;    

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



    }//End
}
