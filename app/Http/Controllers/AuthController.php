<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{

    public function indexLogin()
    {
        return view('pages.login', [
            'title' => "Login",
        ]);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $username  = "$request->username";
        $password  = md5($request->password);
        $user = User::where(['username' => $username, 'password' => $password])->first();

        if ($user == null) {
            return back()->with('loginError', 'Gagal login!!');
        } else {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('umum');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
