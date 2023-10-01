<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialMediaIconController extends Controller
{
    public function index()
    {
        $socialMediaIcons = SocialMediaIcon::all();
        return view('admin.social-media-icons.index', compact('socialMediaIcons'));
    }

    public function create()
    {
        return view('admin.social-media-icons.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon_class' => 'required',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.social_media_icons.create')
                ->withErrors($validator)
                ->withInput();
        }

        SocialMediaIcon::create([
            'name' => $request->input('name'),
            'icon_class' => $request->input('icon_class'),
            'url' => $request->input('url'),
        ]);

        return redirect()->route('admin.social_media_icons.index')
            ->with('success', 'Sosyal medya ikonu başarıyla oluşturuldu.');
    }

    public function edit(SocialMediaIcon $socialMediaIcon)
    {
        return view('admin.social-media-icons.edit', compact('socialMediaIcon'));
    }

    public function update(Request $request, SocialMediaIcon $socialMediaIcon)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon_class' => 'required',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.social_media_icons.edit', $socialMediaIcon->id)
                ->withErrors($validator)
                ->withInput();
        }

        $socialMediaIcon->update([
            'name' => $request->input('name'),
            'icon_class' => $request->input('icon_class'),
            'url' => $request->input('url'),
        ]);

        return redirect()->route('admin.social_media_icons.index')
            ->with('success', 'Sosyal medya ikonu başarıyla güncellendi.');
    }

    public function destroy(SocialMediaIcon $socialMediaIcon)
    {
        $socialMediaIcon->delete();

        return redirect()->route('admin.social_media_icons.index')
            ->with('success', 'Sosyal medya ikonu başarıyla silindi.');
    }
}
