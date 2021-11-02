<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin',['except'=>['logout']]);
    }

    public function showLoginform()
    {
        return redirect(route('login'));
//        return view('auth.userLogin');
    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('login'));
    }
}
