<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use Illuminate\Support\Facades\Response;

class SupportController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
          return redirect("/")->with('error', 'Destek talebi oluşturmak için lütfen giriş yapınız.');
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

    public function supportFileDownload($id){
        $support = Support::find($id);

        if (!$support) {
            return abort(404);
        }

        $destekTalepDosyaYolu = public_path('support/' . $support->file_path);

        if (file_exists($destekTalepDosyaYolu)) {
            return Response::download($destekTalepDosyaYolu);
        } else {
            return abort(404);
            // Dekont bulunamazsa 404 hatası döndür
        }
    }//End
}
