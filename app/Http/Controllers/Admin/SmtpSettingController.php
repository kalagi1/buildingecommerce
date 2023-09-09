<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;

class SmtpSettingController extends Controller
{
    public function edit()
    {
        $smtpSettings = SmtpSetting::first();
        return view('admin.smtp.edit', compact('smtpSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'smtp_server' => 'required',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required',
            'smtp_password' => 'required',
        ]);

        $smtpSettings = SmtpSetting::first();
        $smtpSettings->update($request->all());

        return redirect()->route('admin.smtp.edit')
            ->with('success', 'SMTP ayarları güncellendi');
    }
}
