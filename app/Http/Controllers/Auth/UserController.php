<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\UserModel;
use App\Models\Data\AnggotaModel;
use App\Models\Data\RoleModel;
use App\Models\Master\StatusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Auth::user();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout(); // keluarin user

        // invalidate session & regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function index()
    {
        $data = UserModel::with('anggota', 'roleUser')->get();
        // dd($data);
        // Implement your logic to show the list of users
        foreach ($data as $item) {
            $item->short_password = Str::limit($item->password, 20, '...');
        }
        $anggota = AnggotaModel::whereDoesntHave('user')->get();
        $role = RoleModel::all();
        $status = StatusModel::where('idkategoristatus', 1)->get();
        // dd($anggota);
        return view('konten.users', compact(['data', 'anggota', 'role', 'status']));
    }
    //
}
