<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('client.client-panel.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $user->update($request->all());
        return redirect()->route('client.profile.edit')->with('success', 'Profiliniz başarıyla güncellendi.');
    }
}
