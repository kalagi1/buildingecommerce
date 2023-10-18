<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DocumentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function corporateAccountVerification()
    {
        return view('institutional.home.verification');
    }

    public function verifyAccount(Request $request)
    {
        $request->validate(
            [
                'vergi_levhasi' => 'nullable|image|mimes:jpg,jpeg,png',
                'sicil_belgesi' => 'nullable|image|mimes:jpg,jpeg,png',
                'kimlik_belgesi' => 'nullable|image|mimes:jpg,jpeg,png',
                'insaat_belgesi' => 'nullable|image|mimes:jpg,jpeg,png',
            ]
        );

        $array = [];

        if ($request->hasFile('vergi_levhasi'))
        {
            $file1 = $request->vergi_levhasi->store('tax_documents');
            $array = array_merge($array, ['tax_document' => $file1]);
        }

        if ($request->hasFile('sicil_belgesi'))
        {
            $file2 = $request->sicil_belgesi->store('record_documents');
            $array = array_merge($array, ['record_document' => $file2]);
        }

        if ($request->hasFile('kimlik_belgesi'))
        {
            $file3 = $request->kimlik_belgesi->store('identity_documents');
            $array = array_merge($array, ['identity_document' => $file3]);
        }

        if ($request->hasFile('insaat_belgesi'))
        {
            $file4 = $request->insaat_belgesi->store('company_documents');
            $array = array_merge($array, ['company_document' => $file4]);
        }

        auth()->user()->update($array);

        DocumentNotification::create(
            [
                'user_id' => auth()->user()->id,
                'text' => 'Yeni belge gönderildi. Kullanıcı : '.auth()->user()->email,
            ]
        );

        return redirect()->back();
    }

    public function index()
    {
        $user = User::where("id", Auth::user()->id)->with("plan.subscriptionPlan", "parent")->first();
        if (isset($user->parent)) {
            $user = User::where("id", $user->parent_id)->with("plan.subscriptionPlan", "parent")->first();
        }
        $stats1_data = [];

        DB::beginTransaction();
        for ($i = 1; $i <= date('m'); ++$i) {
            $n = $i + 1;
            if ($i == date('m')) {
                $stats1_data[] = DB::table('housings')->where('user_id', $user->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            } else {
                $stats1_data[] = DB::table('housings')->where('user_id', $user->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            }

        }
        DB::commit();

        $stats2_data = [];

        DB::beginTransaction();
        for ($i = 1; $i <= date('m'); ++$i) {
            $n = $i + 1;
            if ($i == date('m')) {
                $stats2_data[] = DB::table('projects')->where('user_id', $user->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            } else {
                $stats2_data[] = DB::table('projects')->where('user_id', $user->id)->where('created_at', '>=', date("Y-{$i}-01 00:00:00"))->where('created_at', '<', date("Y-{$n}-01 00:00:00"))->count();
            }

        }
        DB::commit();
        

        return view('institutional.home.index', compact("user", "stats1_data", "stats2_data"));
    }
}
