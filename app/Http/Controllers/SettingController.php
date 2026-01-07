<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function account()
    {
        $user = Auth::user();

        return view('dashboard.setting-account', compact('user'));
    }

    public function accountUpdate(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8', // Tambahkan minimal karakter untuk keamanan
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Handle Password (Hapus dari array jika null, Hash jika diisi)
        if ($request->filled('password')) {
            $data['password'] =$request->password;
        } else {
            unset($data['password']); // Hapus agar tidak menimpa password lama saat fill()
        }

        // 2. Handle Profile Image
        if ($request->hasFile('profile')) {
            // Hapus foto lama jika ada (Opsional tapi disarankan agar storage tidak penuh)
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }

            $data['profile'] = $request->file('profile')->store('profile', 'public');
        } else {
            unset($data['profile']); // Pastikan tidak menimpa jika tidak ada upload baru
        }

        // 3. Update dan Simpan
        $user->fill($data);

        if ($user->save()) {
            sweetalert('Data Akun Berhasil di Update', 'success');
        } else {
            sweetalert('Data Akun Gagal di Update', 'error');
        }

        return back();
    }
}
