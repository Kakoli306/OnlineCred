<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{

    public function index()
    {
        return redirect(route('login'));
    }

    public function user_login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        } elseif (Auth::guard('provider')->check()) {
            return redirect(route('provider.dashboard'));
        } else {
            return view('auth.login');
        }
//        return view('auth.userLogin');
    }


    public function user_login_submit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:8'
        ]);
        // if (Auth::guard('admin')->attempt(['name' => $request->email, 'password' => $request->password], $request->remember)) {
        //     return redirect(route('admin.dashboard'));
            if (Auth::guard('admin')->attempt(['name' => $request->email, 'password' => $request->password], $request->remember)) {
                return redirect(route('admin.providers'));
        } elseif (Auth::guard('accountmanager')->attempt(['name' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect(route('account.manager.dashboard'));
        } elseif (Auth::guard('basestaff')->attempt(['name' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect(route('basestaff.dashboard'));
        } elseif (Auth::guard('provider')->attempt(['login_email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect(route('provider.dashboard'));
        } else {
            return redirect()->back()->with('alert', "Invalid Credential");
        }


    }
}
