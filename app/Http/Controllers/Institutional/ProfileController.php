<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->guard("institutional")->user();
        return view('institutional.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $user->update($request->all());
        return redirect()->route('institutional.profile.edit')->with('success', 'Profiliniz başarıyla güncellendi.');
    }
}
