<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $remember = (bool)$request->input('chk-remember');
        if(Auth::attempt(['email' => $request->input('txt-email'), 'password' => $request->input('txt-password')], $remember)) {
            return redirect()->intended('/devices');
        } else {
            $request->session()->flash('login_error', true);
            return back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
