<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomMail;
use App\Models\User;

class SupportController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
          return redirect("/")->with('error', 'Destek talebi oluşturmak için lütfen giriş yapınız.');
        }
        $supports = Support::all();
        return view('admin.support.index', compact('supports'));
    } //End

    public function returnSupport(Request $request){

      $user = User::where('id',$request->user_id)->first();

      $support = Support::findOrFail($request->id);
      $support->return_support = $request->return_support;

      $support->save();

      $subject = "Destek talebiniz yanıtlandı.";

      // Mail::to($user->email)->send(new CustomMail($subject, $request->return_support));

      return back()->with('success', 'Destek talebiniz yanıtlandı.');


    }//End

    public function returnSupportEdit(Request $request){
      $user = User::where('id',$request->user_id)->first();
      $retun_support = $request->return_support;

      $support = Support::findOrFail($request->id);
      $support->return_support = $request->return_support_edit;

      $support->save();

      $subject = "Destek talebiniz yanıtlandı.";

      // Mail::to($user->email)->send(new CustomMail($subject, $request->return_support));

      return back()->with('success', 'Destek talebiniz yenilendi.');
    }//End

}
