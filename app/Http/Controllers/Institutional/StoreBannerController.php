<?php
namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\StoreBanner; // Eğer kullanılacaksa StoreBanner modelini ekleyin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreBannerController extends Controller
{
    public function index()
    {
        $storeBanners = StoreBanner::where("user_id", auth()->user()->parent_id ?? auth()->user()->id)->orderBy("order", "asc")->get();
        return view('client.panel.store_banners.index', compact('storeBanners'));
    }

    public function create()
    {
        return view('client.panel.store_banners.create');
    }

    public function store(Request $request)
    {
        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = 'store_banner_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('store_banners', $fileName, 'public');
                $imagePaths[] = $fileName;
            }
        }

        $parentUser = auth()->user()->parent_id ?? auth()->user()->id;

        $banners = StoreBanner::where("user_id", Auth::user()->parent_id ?? Auth::user()->id)->count();

        foreach ($imagePaths as $key => $imagePath) {
            $storeBanner = new StoreBanner();
            $storeBanner->image = $imagePath;
            $storeBanner->user_id = $parentUser;
            $storeBanner->order = $key + $banners;
            $storeBanner->save();
        }

        return redirect()->route('institutional.storeBanners.index')->with('success', 'Mağaza bannerları başarıyla oluşturuldu.');
    }

    public function edit($hashedId)
    {
        $storeBannerId = decode_id($hashedId);
        $storeBanner = StoreBanner::where("id", $storeBannerId)->first();
       

        return view('client.panel.store_banners.edit', compact('storeBanner'));
    }

    public function update(Request $request, $hashedId)
    {
        $storeBannerId = decode_id($hashedId);
        $storeBanner = StoreBanner::where("id", $storeBannerId)->first();

        $request->validate([
            'image' => 'image',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = 'store_banner_' . Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('store_banners', $imageFileName, 'public');
            $storeBanner->image = $imageFileName;
        }

        $storeBanner->save();

        return redirect()->route('institutional.storeBanners.index')->with('success', 'Mağaza bannerı başarıyla güncellendi.');
    }

    public function destroy($hashedId)
    {
        $storeBannerId = decode_id($hashedId);
        $storeBanner = StoreBanner::where("id", $storeBannerId)->first();

        if ($storeBanner->image) {
            Storage::delete('store_banners/' . $storeBanner->image);
        }

        $storeBanner->delete();

        return redirect()->route('institutional.storeBanners.index')->with('success', 'Mağaza bannerı başarıyla silindi.');
    }

    public function updateOrder(Request $request)
    {
        $user = auth()->user()->parent_id ?? auth()->user()->id;
        $order = $request->input('order');

        foreach ($order as $key => $bannerId) {
            StoreBanner::where('id', $bannerId)
                ->where('user_id', $user)
                ->update(['order' => $key]);
        }

        return response()->json(['success' => true]);
    }

}
