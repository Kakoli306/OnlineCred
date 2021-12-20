<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use App\Models\assign_practice_user;
use App\Models\practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccManPracticeController extends Controller
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
        return back()->with('success', 'Practice Created Successfully');
    }


    public function practice_list()
    {
        $assgn_prc = assign_practice_user::where('user_id', Auth::user()->id)->where('user_type', Auth::user()->account_type)->get();
        $array = [];
        foreach ($assgn_prc as $assprc) {
            array_push($array, $assprc->practice_id);
        }

        $all_practices = practice::whereIn('id', $array)->orderBy('id', 'desc')->paginate(10);
        return view('accountManager.facility.facilityLists', compact('all_practices'));
    }


    public function practice_list_update(Request $request)
    {
        $update_prac = practice::where('id', $request->prc_edit_id)->first();

        if ($request->hasFile('doc_file')) {

            if (!empty($update_prac->doc_file) && file_exists($update_prac->doc_file)) {
                unlink($update_prac->doc_file);
            }

            $image = $request->file('doc_file');
            $name = $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/providerdoc/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_prac->doc_file = $imageUrl;
        }


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
        return back()->with('success', 'Practice Updated Successfully');
    }


}
