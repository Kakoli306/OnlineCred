<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingController extends Controller
{
    public function save_speciality(Request $request)
    {
        $new_spec = new speciality();
        $new_spec->admin_id = Auth::user()->id;
        $new_spec->speciality_name = $request->speciality_name;
        $new_spec->save();
        return back()->with('success','Speciality Successfully Created');
    }


    public function save_speciality_update(Request $request)
    {
        $new_spec = speciality::where('id',$request->speciality_edit)->first();
        $new_spec->speciality_name = $request->speciality_name;
        $new_spec->save();
        return back()->with('success','Speciality Successfully Updated');
    }

    public function save_speciality_delete($id){
        $del_spec = speciality::where('id',$id)->first();
        if ($del_spec) {
            $del_spec->delete();
            return back()->with('success','Speciality Successfully Deleted');
        }else{
            return back()->with('alert','Speciality Not Found');
        }
    }
}
