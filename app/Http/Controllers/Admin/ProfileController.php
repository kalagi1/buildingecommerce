<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $user->update($request->all());
        return redirect()->route('admin.profile.edit')->with('success', 'Profiliniz başarıyla güncellendi.');
    }
}
