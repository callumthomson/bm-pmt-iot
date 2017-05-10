<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /**
     * Display the login page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request POSTed from the login page.
     * Attempt to log in the user with the provided email and password
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Log out the user and take them back to the site root page
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
