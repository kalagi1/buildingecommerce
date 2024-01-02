<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdBannerController extends Controller
{
    public function index()
    {
        $adBanners = AdBanner::all();
        return view('admin.ad-banners.index', compact('adBanners'));
    }

    public function create()
    {
        return view('admin.ad-banners.create');
    }

    public function edit(AdBanner $adBanner)
    {
        return view('admin.ad-banners.edit', compact('adBanner'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image', // Resim validasyonu ekleyin
            'background_color' => 'required',
            'link' => 'required',
            'is_visible' => 'boolean',
        ]);

        // Resmi sakla
        $imagePath = $request->file('image')->store('ad-banners', 'public');

        // Veritabanına kaydet
        $validatedData['image'] = $imagePath;
        AdBanner::create($validatedData);

        return redirect()->route('admin.adBanners.index')->with('success', 'Başarıyla Oluşturuldu');
    }

    public function update(Request $request, AdBanner $adBanner)
    {
        $validatedData = $request->validate([
            'image' => 'nullable|image', // Resim validasyonu ekleyin
            'background_color' => 'required',
            'link' => 'required',
            'is_visible' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Eski resmi sil
            Storage::disk('public')->delete($adBanner->image);

            // Yeni resmi sakla
            $imagePath = $request->file('image')->store('ad-banners', 'public');
            $validatedData['image'] = $imagePath;
        }

        $adBanner->update($validatedData);

        return redirect()->route('admin.adBanners.index')->with('success', 'Başarıyla Güncellendi');
    }

    public function destroy(AdBanner $adBanner)
    {
        $adBanner->delete();

        return redirect()->route('admin.adBanners.index')->with('success', 'Başarıyla Silindi');
    }
}
