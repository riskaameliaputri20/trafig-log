<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function account()
    {
        $user = Auth::user();

        return view("dashboard.setting-account", compact('user'));
    }
    public function accountUpdate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . auth()->id(),
            'password' => 'nullable',
            'profile' => 'nullable',
        ]);
        if (isset($data['profile']) && $data['profile']) {
            $data['profile'] = $request->file('profile')->store('profile', 'public');
        }
        $user = Auth::user();
        $user->fill($data);
        if ($user->save()) {
            sweetalert('Data Akun Berhasil di Update', 'success');
        } else {
            sweetalert('Data Akun Gagal di Update', 'error');
        }

        return back();

    }
}
