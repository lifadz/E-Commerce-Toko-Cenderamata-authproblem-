<?php

namespace App\Http\Controllers\admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(){

        return view('admin.dashboard');
        // $admin = Auth::guard('admin')->user();
        
        // echo 'welcome '.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }

    public function logout(){
        
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function showProfileForm()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validasi input jika diperlukan
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'profile_image' => 'image|max:2048',
    ]);

    // Simpan nilai saat ini sebelum diubah
    $currentName = $user->name;
    $currentEmail = $user->email;
    $currentProfileImage = $user->profile_image;

    // Update nama dan email
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    // Update gambar profil
    if ($request->hasFile('profile_image')) {
        // Hapus gambar lama jika ada
        Storage::delete('profile_images/' . $currentProfileImage);

        // Simpan gambar baru
        $user->profile_image = $request->file('profile_image')->store('profile_images', 'public');
    }

    // Cek apakah ada perubahan
    if ($currentName == $user->name && $currentEmail == $user->email && $currentProfileImage == $user->profile_image) {
        return redirect()->route('admin.profile')->with('alert', 'Anda tidak melakukan perubahan apapun.');
    }

    // Simpan perubahan
      /** @var \App\Models\User $user **/
    $user->save();

    return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui');
}

}        