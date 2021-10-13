<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\practice;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPracticeController extends Controller
{
    public function practice_save(Request $request)
    {
        $new_prac = new practice();
        $new_prac->admin_id = Auth::user()->id;
        $new_prac->business_name = $request->business_name;
        $new_prac->dba_name = $request->dba_name;
        $new_prac->tax_id = $request->tax_id;
        $new_prac->npi = $request->npi;
        $new_prac->address = $request->address;
        $new_prac->city = $request->city;
        $new_prac->state = $request->state;
        $new_prac->zip = $request->zip;
        $new_prac->phone_number = $request->phone_number;
        $new_prac->medicaid = $request->medicaid;
        $new_prac->save();
        return back()->with('success','Practice Created Successfully');
    }


    public function practice_lists()
    {
        $all_practices = practice::where('admin_id',Auth::user()->id)->paginate(20);
        return view('admin.facility.facilityLists',compact('all_practices'));
    }

    public function practice_update(Request $request)
    {
        $update_prac = practice::where('id',$request->prc_edit_id)->first();
        $update_prac->admin_id = Auth::user()->id;
        $update_prac->business_name = $request->business_name;
        $update_prac->dba_name = $request->dba_name;
        $update_prac->tax_id = $request->tax_id;
        $update_prac->npi = $request->npi;
        $update_prac->address = $request->address;
        $update_prac->city = $request->city;
        $update_prac->state = $request->state;
        $update_prac->zip = $request->zip;
        $update_prac->phone_number = $request->phone_number;
        $update_prac->medicaid = $request->medicaid;
        $update_prac->save();
        return back()->with('success','Practice Updated Successfully');
    }


    public function practice_delete($id)
    {
        $check_exists_data = Provider::where('facility_id',$id)->count();
        if ($check_exists_data > 0) {
            return back()->with('alert',"Practice Have Provider. You Can't Delete");
        }else{
            $delete_prac = practice::where('id',$id)->first();
            $delete_prac->delete();
            return back()->with('success','Practice Deleted Successfully');
        }

    }



}
