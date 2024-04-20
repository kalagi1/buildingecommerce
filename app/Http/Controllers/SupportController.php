<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;

class SupportController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            redirect("/");
        }
        $supports = Support::where('user_id', Auth::id())->get();
        $contract_pages = Page::where('is_contract_page', 1)->get();
        return view('support.index', compact('supports', 'contract_pages'));
    } //End

    public function sendSupportMessage(Request $request)
    {
        $fileName = null;
        // Dosya yükleme işlemi
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('temp');
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('support'), $fileName);
        } else {
            $fileName = null;
        }



        // Support modeli ile yeni bir kayıt oluştur
        $support = new Support();
        $support->user_id = Auth::id();
        $support->category = $request->category;
        $support->send_reason = $request->sendReason;
        $support->description = $request->description;
        $support->file_path = $fileName; // Dosya yolunu kaydet

        $support->save();

        return redirect()->back()->with('success', 'Talebiniz başarıyla alındı.');
    } //End

    public function get_kvkk(Request $request)
    {
        $kvkk = Page::where('id', 12)->value('content');
        return response()->json(['kvkk' => $kvkk]);
    } //End
}
