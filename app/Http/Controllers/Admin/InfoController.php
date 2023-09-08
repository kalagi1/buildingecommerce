<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function about()
    {
        return view('admin.info.about_us');
    }
    public function aboutUsSetOrEdit(Request $req)
    {

        $postData = $req->validate([
            'text' => 'required|string',
            'image' => 'required|image'
        ]);
        $image = $postData['image'];
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image_path = $image->storeAs('about/', $fileName, 'public');
        $about = AboutUs::first();

        if (!$about) {
            AboutUs::create($postData);
        } else {
            $about->text = $postData['text'];
            $about->image = $image_path;
            $about->save();
        }
        return redirect()->route('admin.info.about.index')->with('success', 'About us info setted');
    }
    public function contact()
    {

    }
    public function contactSetOrEdit()
    {
        // Validation kuralları
        $this->validate(request(), [
            'address' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'working_time' => 'required',
        ]);


        $contact_info = request()->only('address', 'location', 'phone', 'email', 'working_time');

        $contact_info_model = ContactInfo::first();

        if ($contact_info_model) {
            $contact_info_model->update($contact_info);
        } else {
            $contact_info_model = ContactInfo::create($contact_info);
        }

        // Başarılı mesajı döndür
        return response()->json(['success' => true, 'message' => 'İletişim bilgileri kaydedildi.'], 200);
    }
}