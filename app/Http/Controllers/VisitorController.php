<?php

namespace App\Http\Controllers;

use App\Models\portal_access_email;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VisitorController extends Controller
{
    public function account_setup($token)
    {
        $access = portal_access_email::where('verify_id',$token)->where('is_use',0)->first();
        if ($access) {
            return view('auth.accPasswordSet',compact('access'));
        }else{
            return redirect(route('user.login'))->with('alert','Access Link Has Been Disabled');
        }
    }

    public function account_password_setup(Request $request)
    {

        $pass = $request->pass;
        $cpass = $request->cpass;

        if ($pass != $cpass) {
            return back()->with('alert','Password Not Match');
        }elseif(strlen($pass) < 8 || strlen($cpass) < 8){
            return back()->with('alert','Password and Confirm Password must be at least 8 characters with special characters');
        }else{


            $access = portal_access_email::where('verify_id',$request->token_id)->first();
            $access->is_use = 1;
            $access->save();

            $provider = Provider::where('id',$access->provider_id)->first();
            $provider->login_email = $access->email;
            $provider->password = Hash::make($pass);
            $provider->save();
            return redirect(route('user.login'))->with('success','Password Setup Successfully. Please Login');
        }

    }

}
