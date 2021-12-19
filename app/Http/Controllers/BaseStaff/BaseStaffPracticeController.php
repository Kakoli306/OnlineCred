<?php

namespace App\Http\Controllers\BaseStaff;

use App\Http\Controllers\Controller;
use App\Models\assign_practice_user;
use App\Models\practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseStaffPracticeController extends Controller
{
    public function practice_list()
    {
        $ass_prc = assign_practice_user::where('user_id', Auth::user()->id)->where('user_type', Auth::user()->account_type)->get();
        $array = [];
        foreach ($ass_prc as $assprc) {
            array_push($array, $assprc->practice_id);
        }

        $all_practices = practice::whereIn('id', $array)->paginate(20);
        return view('baseStaff.facility.facilityLists', compact('all_practices'));
    }


    public function practice_update(Request $request)
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
