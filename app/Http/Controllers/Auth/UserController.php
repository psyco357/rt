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
    public function profil()
    {
        $user = UserModel::with('anggota')->find(Auth::id());
        // dd($user);
        $anggota = AnggotaModel::where('id', $user->idanggota)->first();
        return view('konten.profil', compact(['user', 'anggota']));
    }
    public function updateProfil(Request $request)
    {
        $user = UserModel::with('anggota')->find(Auth::id());
        // dd($user->anggota->save());
        try {
            // Validasi jika perlu
            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'namaanggota' => 'required|string|max:255',
                'alamatanggota' => 'nullable|string|max:255',
                'no_telepon' => 'nullable|string|max:20',
            ]);

            // Update user
            $user->username = $request->username;
            $user->email = $request->email;

            // Periksa apakah anggota terkait ada
            if ($user->anggota) {
                $user->anggota->nama = $request->namaanggota;
                $user->anggota->alamat = $request->alamatanggota;
                $user->anggota->no_telepon = $request->no_telepon;

                // Simpan perubahan anggota
                $user->anggota->save();
            }

            if ($request->filled('new_password')) {
                // Validasi password jika ada
                $request->validate([
                    'new_password' => 'nullable|string|min:8|confirmed',
                ]);
                $user->password = Hash::make($request->new_password);
            }
            // dd($request->filled('new_password'));
            // Simpan perubahan user
            if ($user->save()) {
                return back()->with('success', 'Informasi berhasil diperbarui.');
            }
            return back()->withErrors($e->errors())->withInput();

            // Return back with success message
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mengembalikan error ke halaman sebelumnya
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Error lainnya
            \Log::error('Error updating profile: ' . $e->getMessage()); // Log error ke file
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validations = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255',
            'ktp' => 'required|max:255',
            'role' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
 
        $user = new UserModel;
        $user->idanggota = $request->ktp;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->name = $request->username;
        $user->role = $request->role;
        $user->isactive = $request->status;
        if ($request->filled('password')) {
            // Validasi password jika ada
            $request->validate([
                'password' => 'nullable|string|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }
        // dd($user->password);
        if ($user->save()) {
            return response()->json(['success' => 'User berhasil ditambahkan']);
        } else {
            return response()->json(['error' => 'Gagal menyimpan user'], 500);
        }
    }
}
