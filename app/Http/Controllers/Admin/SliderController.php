<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\FooterSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function footerIndex()
    {
        $sliders = FooterSlider::all();
        return view('admin.footer-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function footerCreate()
    {
        return view('admin.footer-sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'mobile_image' => 'required|image|mimes:jpeg,png,jpg,gif',

        ]);

        $image = $request->file('image');
        $fileName = 'slider_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('sliders', $fileName, 'public');

        $mobile_image = $request->file('mobile_image');
        $fileNameMobile = 'slider_' . time() . '.' . $mobile_image->getClientOriginalExtension();
        $mobile_image->storeAs('sliders', $fileNameMobile, 'public');

        $slider = new Slider();
        $slider->title = $request->input('title');
        $slider->image = $fileName;
        $slider->mobile_image = $fileNameMobile;

        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider başarıyla oluşturuldu.');
    }

    public function footerStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $image = $request->file('image');
        $fileName = 'slider_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('footer-sliders', $fileName, 'public');

        $mobile_image = $request->file('mobile_image');
        $fileNameMobile = 'slider_' . time() . '.' . $mobile_image->getClientOriginalExtension();
        $mobile_image->storeAs('footer-sliders', $fileNameMobile, 'public');

        $slider = new FooterSlider();
        $slider->title = $request->input('title');
        $slider->image = $fileName;
        $slider->mobile_image = $fileNameMobile;
        $slider->save();

        return redirect()->route('admin.footer-sliders.index')->with('success', 'Slider başarıyla oluşturuldu.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function footerEdit(FooterSlider $slider)
    {
        return view('admin.footer-sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = 'slider_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/sliders', $imageFileName);
            $slider->image = $imageFileName;
        }


        if ($request->hasFile('mobile_image')) {
            $mobile_image = $request->file('mobile_image');
            $imageFileNameMobile = 'slider_' . time() . '.' . $mobile_image->getClientOriginalExtension();
            $mobile_image->storeAs('public/sliders', $imageFileNameMobile);
            $slider->mobile_image = $imageFileNameMobile;
        }

        $slider->title = $request->input('title');
        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider başarıyla güncellendi.');
    }

    public function footerUpdate(Request $request, FooterSlider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = 'slider_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/footer-sliders', $imageFileName);
            $slider->image = $imageFileName;
        }


        if ($request->hasFile('mobile_image')) {
            $mobile_image = $request->file('mobile_image');
            $imageFileNameMobile = 'slider_' . time() . '.' . $mobile_image->getClientOriginalExtension();
            $mobile_image->storeAs('public/footer-sliders', $imageFileNameMobile);
            $slider->mobile_image = $imageFileNameMobile;
        }


        $slider->title = $request->input('title');
        $slider->save();

        return redirect()->route('admin.footer-sliders.index')->with('success', 'Slider başarıyla güncellendi.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::delete('public/sliders/' . $slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider başarıyla silindi.');
    }

    public function footerDestroy(FooterSlider $slider)
    {
        if ($slider->image) {
            Storage::delete('public/footer-sliders/' . $slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.footer-sliders.index')->with('success', 'Slider başarıyla silindi.');
    }
}
