<?php
namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\StoreBanner; // Eğer kullanılacaksa StoreBanner modelini ekleyin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreBannerController extends Controller
{
    public function index()
    {
        $storeBanners = StoreBanner::all();
        return view('institutional.store-banners.index', compact('storeBanners'));
    }

    public function create()
    {
        return view('institutional.store-banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $image = $request->file('image');
        $fileName = 'store_banner_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('store-banners', $fileName, 'public');

        $storeBanner = new StoreBanner();
        $storeBanner->title = $request->input('title');
        $storeBanner->image = $fileName;
        $storeBanner->save();

        return redirect()->route('institutional.store-banners.index')->with('success', 'Mağaza bannerı başarıyla oluşturuldu.');
    }

    public function edit(StoreBanner $storeBanner)
    {
        return view('institutional.store-banners.edit', compact('storeBanner'));
    }

    public function update(Request $request, StoreBanner $storeBanner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = 'store_banner_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('store-banners', $imageFileName, 'public');
            $storeBanner->image = $imageFileName;
        }

        $storeBanner->title = $request->input('title');
        $storeBanner->save();

        return redirect()->route('institutional.store-banners.index')->with('success', 'Mağaza bannerı başarıyla güncellendi.');
    }

    public function destroy(StoreBanner $storeBanner)
    {
        if ($storeBanner->image) {
            Storage::delete('store-banners/' . $storeBanner->image);
        }

        $storeBanner->delete();

        return redirect()->route('institutional.store-banners.index')->with('success', 'Mağaza bannerı başarıyla silindi.');
    }

}
