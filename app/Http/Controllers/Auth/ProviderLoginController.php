<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:provider',['except'=>['logout']]);
    }


    public function provider_login_form()
    {
        return view('auth.providerLogin');
    }



    //this is login function for admin which is given email and password to get data form database
    public function provider_login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required|min:8'
        ]);
        if(Auth::guard('provider')->attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)){
            return redirect(route('provider.dashboard'));
        }

        return redirect()->back();

    }



    //this funsion for admin logout which i customized to cpy form loginController
    public function provider_logout()
    {
        Auth::guard('provider')->logout();
        return redirect(route('user.login'));
    }
}
