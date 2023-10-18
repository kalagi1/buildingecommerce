<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\ContactInfo;
use App\Models\DocumentNotification;
use Illuminate\Http\Request;

class InfoController extends Controller
{

    function setReadedDn(Request $request, DocumentNotification $dn)
    {
        $dn->update(['readed' => 1]);
        return redirect()->back();
    }

    public function contact()
    {
        $contactInfo = ContactInfo::first();

        return view('admin.info.contact', compact('contactInfo'));
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


        return redirect()->route('admin.info.contact.index')->with('success', 'İletişim bilgileri kaydedildi');
    }
}