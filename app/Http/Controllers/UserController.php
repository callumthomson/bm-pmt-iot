<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use Validator;

class UserController extends Controller
{
    public function getProfile()
    {
        return view('user.profile');
    }

    public function postProfile(Request $request)
    {
        $messages = [
            'txt-name.required' => 'Your name is required.',
            'txt-name.max' => 'Your name is too long.',
            'txt-email.required' => 'Your email address is required.',
            'txt-email.email' => 'Your email address is invalid.',
            'txt-email.max' => 'Your email address is too long.',
        ];
        $validator = Validator::make($request->all(), [
            'txt-name' => 'required|max:255',
            'txt-email' => 'required|email|max:255',
        ], $messages);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            Auth::user()->name = $request->input('txt-name');
            Auth::user()->email = $request->input('txt-email');
            Auth::user()->save();

            $request->session()->flash('save_status', true);
            return back();
        }
    }

    public function getChangePassword()
    {
        return view('user.changepassword');
    }

    public function postChangePassword(Request $request)
    {
        // Check the current password is correct first
        if(!Hash::check($request->input('txt-cpassword'), Auth::user()->password)) {
            $request->session()->flash('password_error', true);
            return back();
        }

        // Now check the new passwords
        $messages = [
            'txt-password1.required' => 'You need to provide another password',
            'txt-password1.max' => 'Your new password is too long',
            'txt-password2.same' => 'Your password confirmation does not match the new password',
        ];
        $validator = Validator::make($request->all(), [
            'txt-password1' => 'required|max:255',
            'txt-password2' => 'same:txt-password1',
        ], $messages);

        if($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            Auth::user()->password = Hash::make($request->input('txt-password1'));
            Auth::user()->save();

            $request->session()->flash('save_status', true);
            return back();
        }
    }
}
