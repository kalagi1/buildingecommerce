<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function create()
    {
        return view('institutional.brands.create'); // Brand oluşturma formunu gösteren bir view döndürün
    }

    public function store(Request $request)
    {
        // Formdan gelen dosyaları al
        $logo = $request->file('logo');
        $coverPhoto = $request->file('cover_photo');
        
        // Yükleme için dosya adlarını oluştur
        $logoFileName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
        $coverPhotoFileName = 'cover_photo_' . time() . '.' . $coverPhoto->getClientOriginalExtension();

        // Dosyaları public/brand_images klasörüne kaydet
        $logo->storeAs('brand_images', $logoFileName, 'public');
        $coverPhoto->storeAs('brand_images', $coverPhotoFileName, 'public');

        // Veritabanına kaydet
        $brand = new Brand();
        $brand->title = $request->input('title');
        $brand->logo = $logoFileName;
        $brand->cover_photo = $coverPhotoFileName;
        $brand->user_id = auth('institutional')->id(); // Auth kullanıcısının ID'sini al
        $brand->save();

        return redirect()->route('institutional.brands.index')->with('success', 'Marka başarıyla oluşturuldu.');
    }

    public function index()
    {
        $brands = Brand::where('user_id', auth('institutional')->id())->get(); // Kullanıcının markalarını getir
        return view('institutional.brands.index', compact('brands'));
    }
}
