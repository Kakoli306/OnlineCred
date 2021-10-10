<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\practice;
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
}
