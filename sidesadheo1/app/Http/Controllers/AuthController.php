<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;

            if ($userStatus == 'submitted') {
                return back()->witherrors([
                    'email' => 'Akun anda menunggu persetujuan admin'
            ]);
            } else if ($userStatus =='rejected') {
                return back()->withErrors([
                    'email', 'Akun anda telah ditolak admin'
            ]);   
            }

            return redirect()->intended('dashboard');
        
        }
        return back()->withErrors([
            'email' => 'terjadi kesalahan, periksa kembali email atau password anda',
        ])->onlyInput('email');
    }

    public function registerView()
    {
        return view('pages.auth.register');
    }

    public function register(request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],

        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make( $request->input('password'));
        $user->role_id = 2; //=> user(penduduk)
        $user->saveOrFail();

        return redirect('/')->with('success', 'berhasil menggunakan akun, menunggu persetujuan admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
