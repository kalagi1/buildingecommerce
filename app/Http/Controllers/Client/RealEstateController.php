<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\RealEstateForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealEstateController extends Controller
{
    public function index(){
        $pageInfo = [
            "meta_title" => "Sat Kirala",
            "meta_keywords" => "Emlak Sepette,Sat Kirala",
            "meta_description" => "Emlak Kulüp Sat Kirala, uzman danışmanlarımızla en uygun fiyatlarla konut sahibi olun veya emlak yatırımı yapın. Güvenilir hizmet ve geniş portföyümüzle size en uygun seçenekleri sunuyoruz!",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);

        $cities = City::all();
        return view('client.realestate-form.index',compact('pageInfo','cities'));
    }

    public function index2(){
        $pageInfo = [
            "meta_title" => "Sat Kirala",
            "meta_keywords" => "Emlak Sepette,Sat Kirala",
            "meta_description" => "Emlak Kulüp Sat Kirala, uzman danışmanlarımızla en uygun fiyatlarla konut sahibi olun veya emlak yatırımı yapın. Güvenilir hizmet ve geniş portföyümüzle size en uygun seçenekleri sunuyoruz!",
            "meta_author" => "Emlak Sepette",
        ];

        $pageInfo = json_encode($pageInfo);
        $pageInfo = json_decode($pageInfo);
        return view('client.realestate-form.index2',compact('pageInfo'));
    }

    public function store(Request $request){

        // Kullanıcı giriş yapmış mı kontrol et
        if (!Auth::check()) {
            return redirect()->route('client.login');
        }

        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'adres' => 'required|string',
            'istenilen_fiyat' => 'required|string',
            'ilan_aciklamasi' => 'required|string',
            'yapi_tipi' => 'required|string',
            'bina_kat' => 'required|string',
            'bulundugu_kat' => 'required|string',
            'm2_net' => 'required|string',
            'm2_brut' => 'required|string',
            'bina_yasi' => 'required|string',
            'cephe' => 'required|string',
            'manzara' => 'required|string',
            'banyo_tuvalet' => 'required|string',
            'isinma' => 'required|string',
            'oda_salon' => 'required|string',
            'tapu' => 'required|string',
        ],[
            "name.required" => "İsim soyisim alanı zorunludur",
            "phone.required" => "Telefon alanı zorunludur",
            "email.required" => "E-Posta adresi alanı zorunludur",
            "adres.required" => "Adres alanı zorunludur",
            "istenilen_fiyat.required" => "İstenilen fiyat alanı zorunludur",
            "ilan_aciklamasi.required" => "İlan açıklaması alanı zorunludur",
            "yapi_tipi.required" => "Yapı tipi alanı zorunludur",
            "bina_kat.required" => "Bina Kat alanı zorunludur",
            "bulundugu_kat.required" => "Bulunduğu kat alanı zorunludur",
            "m2_net.required" => "Metrekare net alanı zorunludur",
            "m2_brut.required" => "Metrekare brüt alanı zorunludur",
            "bina_yasi.required" => "Bina yaşı alanı zorunludur",
            "cephe.required" => "Cephe alanı zorunludur",
            "manzara.required" => "Manzara alanı zorunludur",
            "banyo_tuvalet.required" => "Banyo Tuvalet alanı zorunludur",
            "isinma.required" => "Isınma alanı zorunludur",
            "oda_salon.required" => "Oda salon alanı zorunludur",
            "tapu.required" => "Tapu alanı zorunludur",
        ]);

        RealEstateForm::create([
            "name" => $request->input('name'),
            "phone" => $request->input('phone'),
            "email" => $request->input('email'),
            "konut" => $request->input('type_1') == "konut" ? 1 : 0,
            "ticari" => $request->input('type_1') == "ticari" ? 1 : 0,
            "kiralik" => $request->input('type_2') == "kiralik" ? 1 : 0,
            "satilik" => $request->input('type_2') == "satilik" ? 1 : 0,
            "devren" => $request->input('type_2') == "devren" ? 1 : 0,
            "adres" => $request->input('adres'),
            "istenilen_fiyat" => $request->input('istenilen_fiyat'),
            "ilan_aciklamasi" => $request->input('ilan_aciklamasi'),
            "sozlesme" => $request->input('sozlesme') ? 1 : 0,
            "afis" => $request->input('afis') ? 1 : 0,
            "anahtar_yetkili" => $request->input('anahtar_yetkili') ? 1 : 0,
            "yapi_tipi" => $request->input('yapi_tipi'),
            "bina_kat" => $request->input('bina_kat'),
            "bulundugu_kat" => $request->input('bulundugu_kat'),
            "m2_net" => $request->input('m2_net'),
            "m2_brut" => $request->input('m2_brut'),
            "bina_yasi" => $request->input('bina_yasi'),
            "cephe" => $request->input('cephe'),
            "manzara" => $request->input('manzara'),
            "banyo_tuvalet" => $request->input('banyo_tuvalet'),
            "isinma" => $request->input('isinma'),
            "oda_salon" => $request->input('oda_salon'),
            "tapu" => $request->input('tapu'),
            "user_id" => Auth::user()->id ?? null,
            "dsl" => in_array("DSL",$request->input('features')) ? 1 : 0,
            "asansor" => in_array("ASANSÖR",$request->input('features')) ? 1 : 0,
            "esyali" => in_array("EŞYALI",$request->input('features')) ? 1 : 0,
            "garaj" => in_array("GARAJ",$request->input('features')) ? 1 : 0,
            "barbeku" => in_array("BARBEKÜ",$request->input('features')) ? 1 : 0,
            "boyali" => in_array("BOYALI",$request->input('features')) ? 1 : 0,
            "cam_odasi" => in_array("ÇAM. ODASI",$request->input('features')) ? 1 : 0,
            "celik_kapi" => in_array("ÇELİK KAPI",$request->input('features')) ? 1 : 0,
            "dusakabin" => in_array("DUŞAKABİN",$request->input('features')) ? 1 : 0,
            "intercom" => in_array("İNTERCOM",$request->input('features')) ? 1 : 0,
            "jakuzi" => in_array("JAKUZİ",$request->input('features')) ? 1 : 0,
            "msd" => in_array("M.S.D.",$request->input('features')) ? 1 : 0,
            "jenerator" => in_array("JENERATÖR",$request->input('features')) ? 1 : 0,
            "mutfak_d" => in_array("MUTFAK D.",$request->input('features')) ? 1 : 0,
            "sauna" => in_array("SAUNA",$request->input('features')) ? 1 : 0,
            "seramik_z" => in_array("SERAMİK Z.",$request->input('features')) ? 1 : 0,
            "su_deposu" => in_array("SU DEPOSU",$request->input('features')) ? 1 : 0,
            "somine" => in_array("ŞÖMİNE",$request->input('features')) ? 1 : 0,
            "teras" => in_array("TERAS",$request->input('features')) ? 1 : 0,
            "guvenlik" => in_array("GÜVENLİK",$request->input('features')) ? 1 : 0,
            "gonme_dolap" => in_array("GÖNME DOLAP",$request->input('features')) ? 1 : 0,
            "kablo_tv" => in_array("KABLO TV",$request->input('features')) ? 1 : 0,
            "mutfak_l" => in_array("MUTFAK L.",$request->input('features')) ? 1 : 0,
            "otopark" => in_array("OTOPARK",$request->input('features')) ? 1 : 0,
            "gor_diafon" => in_array("GÖR. DİAFON",$request->input('features')) ? 1 : 0,
            "kiler" => in_array("KİLER",$request->input('features')) ? 1 : 0,
            "oyun_parki" => in_array("OYUN PARKI",$request->input('features')) ? 1 : 0,
            "hidrofor" => in_array("HİDROFOR",$request->input('features')) ? 1 : 0,
            "klima" => in_array("KLİMA",$request->input('features')) ? 1 : 0,
            "pvc" => in_array("PVC",$request->input('features')) ? 1 : 0,
            "hilton_banyo" => in_array("HİLTON BANYON",$request->input('features')) ? 1 : 0,
            "kombi" => in_array("KOMBİ",$request->input('features')) ? 1 : 0,
            "panjur" => in_array("PANJUR",$request->input('features')) ? 1 : 0,
            "isicam" => in_array("ISICAM",$request->input('features')) ? 1 : 0,
            "laminant_z" => in_array("LAMİNANT Z.",$request->input('features')) ? 1 : 0,
            "parke" => in_array("PARKE",$request->input('features')) ? 1 : 0,
            "yangin_m" => in_array("YANGIN M.",$request->input('features')) ? 1 : 0,
            "yuzme_havuzu" => in_array("YÜZME H.",$request->input('features')) ? 1 : 0,
            "wifi" => in_array("Wi-Fi",$request->input('features')) ? 1 : 0,
        ]);

        return redirect()->route('real.estate.index',["status" => "new_form_send"]);
    }

 

    public function getDistricts($cityId){
   
        $districts = District::where('ilce_sehirkey', $cityId)->get();
 
        return response()->json($districts);
    }//End

    public function getNeighborhoods($districtId){
   
        $neighborhoods = Neighborhood::where('mahalle_ilcekey', $districtId)->get();

        // $neighborhoods = DB::table('neighborhoods')->where('')
 
        return response()->json($neighborhoods);    
    }//End

}
