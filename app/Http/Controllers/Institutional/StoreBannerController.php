<?php
namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\StoreBanner; // Eğer kullanılacaksa StoreBanner modelini ekleyin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreBannerController extends Controller
{
    public function index()
    {
        $storeBanners = StoreBanner::all();
        return view('institutional.store_banners.index', compact('storeBanners'));
    }

    public function create()
    {
        return view('institutional.store_banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $fileName = 'store_banner_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('store_banners', $fileName, 'public');

        $storeBanner = new StoreBanner();
        $storeBanner->image = $fileName;
        $storeBanner->user_id = Auth::user()->id;
        $storeBanner->save();

        return redirect()->route('institutional.storeBanners.index')->with('success', 'Mağaza bannerı başarıyla oluşturuldu.');
    }

    public function edit(StoreBanner $storeBanner)
    {
        return view('institutional.store_banners.edit', compact('storeBanner'));
    }

    public function update(Request $request, StoreBanner $storeBanner)
    {
        $request->validate([
            'image' => 'image',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = 'store_banner_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('store_banners', $imageFileName, 'public');
            $storeBanner->image = $imageFileName;
        }

        $storeBanner->save();

        return redirect()->route('institutional.storeBanners.index')->with('success', 'Mağaza bannerı başarıyla güncellendi.');
    }

    public function destroy(StoreBanner $storeBanner)
    {
        if ($storeBanner->image) {
            Storage::delete('store_banners/' . $storeBanner->image);
        }

        $storeBanner->delete();

        return redirect()->route('institutional.storeBanners.index')->with('success', 'Mağaza bannerı başarıyla silindi.');
    }

}
