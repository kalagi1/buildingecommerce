<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $status = $request->input('status', 0); // Eğer status değeri gelmezse varsayılan olarak 0 (Pasif) kabul eder

        // Veritabanına kaydet
        $brand = new Brand();
        $brand->title = $request->input('title');
        $brand->logo = $logoFileName;
        $brand->cover_photo = $coverPhotoFileName;
        $brand->user_id = auth('institutional')->id();
        $brand->status = $status; // Status değerini kaydet
        $brand->save();

        return redirect()->route('institutional.brands.index')->with('success', 'Marka başarıyla oluşturuldu.');
    }

    public function index()
    {
        $brands = Brand::where('user_id', auth('institutional')->id())->get(); // Kullanıcının markalarını getir
        return view('institutional.brands.index', compact('brands'));
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id); // Düzenlenecek markayı bulun
        return view('institutional.brands.edit', compact('brand')); // Marka düzenleme formunu gösteren bir view döndürün
    }

    public function update(Request $request, $id)
    {
        // Formdan gelen dosyaları al
        $logo = $request->file('logo');
        $coverPhoto = $request->file('cover_photo');

        // Düzenlenecek markayı bulun
        $brand = Brand::findOrFail($id);

        // Marka verilerini güncelle
        $brand->title = $request->input('title');
        
        if ($logo) {
            // Yeni logo yüklendiyse eski logoyu sil ve yeni logo kaydet
            if ($brand->logo) {
                Storage::disk('public')->delete('brand_images/' . $brand->logo);
            }
            $logoFileName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('brand_images', $logoFileName, 'public');
            $brand->logo = $logoFileName;
        }

        if ($coverPhoto) {
            // Yeni kapak fotoğrafı yüklendiyse eski kapak fotoğrafını sil ve yeni kapak fotoğrafını kaydet
            if ($brand->cover_photo) {
                Storage::disk('public')->delete('brand_images/' . $brand->cover_photo);
            }
            $coverPhotoFileName = 'cover_photo_' . time() . '.' . $coverPhoto->getClientOriginalExtension();
            $coverPhoto->storeAs('brand_images', $coverPhotoFileName, 'public');
            $brand->cover_photo = $coverPhotoFileName;
        }

        // Aktiflik durumunu güncelle
        $brand->status = $request->has('status') ? 1 : 0;

        // Veritabanına kaydet
        $brand->save();

        return redirect()->route('institutional.brands.index')->with('success', 'Marka başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        // Silinecek markayı bulun
        $brand = Brand::findOrFail($id);

        // Marka dosyalarını sil
        if ($brand->logo) {
            Storage::disk('public')->delete('brand_images/' . $brand->logo);
        }
        if ($brand->cover_photo) {
            Storage::disk('public')->delete('brand_images/' . $brand->cover_photo);
        }

        // Markayı veritabanından sil
        $brand->delete();

        return redirect()->route('institutional.brands.index')->with('success', 'Marka başarıyla silindi.');
    }
}
