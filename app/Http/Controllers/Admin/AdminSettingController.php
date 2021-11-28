<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\contact_name;
use App\Models\contact_type;
use App\Models\insurance;
use App\Models\speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingController extends Controller
{


    public function speciality()
    {
        $all_scpec = speciality::where('admin_id', Auth::user()->id)->paginate(10);
        return view('admin.setting.speciality', compact('all_scpec'));
    }


    public function save_speciality(Request $request)
    {
        $new_spec = new speciality();
        $new_spec->admin_id = Auth::user()->id;
        $new_spec->speciality_name = $request->speciality_name;
        $new_spec->save();
        return back()->with('success', 'Speciality Successfully Created');
    }


    public function save_speciality_update(Request $request)
    {
        $new_spec = speciality::where('id', $request->speciality_edit)->first();
        $new_spec->speciality_name = $request->speciality_name;
        $new_spec->save();
        return back()->with('success', 'Speciality Successfully Updated');
    }

    public function save_speciality_delete($id)
    {
        $del_spec = speciality::where('id', $id)->first();
        if ($del_spec) {
            $del_spec->delete();
            return back()->with('success', 'Speciality Successfully Deleted');
        } else {
            return back()->with('alert', 'Speciality Not Found');
        }
    }


    public function contact_name()
    {
        $all_contact_name = contact_name::where('admin_id', Auth::user()->id)->paginate(10);
        return view('admin.setting.contactName', compact('all_contact_name'));
    }

    public function contact_name_save(Request $request)
    {
        $new_contact = new contact_name();
        $new_contact->admin_id = Auth::user()->id;
        $new_contact->contact_name = $request->contact_name;
        $new_contact->save();
        return back()->with('success', 'Contact Name Created Successfully');
    }

    public function contact_name_update(Request $request)
    {
        $new_contact = contact_name::where('id', $request->contact_name_edit)->first();
        $new_contact->contact_name = $request->contact_name;
        $new_contact->save();
        return back()->with('success', 'Contact Name Updated Successfully');
    }


    public function contact_name_delete($id)
    {
        $delete_contact_name = contact_name::where('id', $id)->first();
        $delete_contact_name->delete();
        return back()->with('success', 'Contact Name Deleted Successfully');
    }


    public function contact_type()
    {
        $contact_types = contact_type::where('admin_id', Auth::user()->id)->paginate(10);
        return view('admin.setting.contactType', compact('contact_types'));
    }


    public function contact_type_save(Request $request)
    {
        $new_contact_type = new contact_type();
        $new_contact_type->admin_id = Auth::user()->id;
        $new_contact_type->contact_type = $request->contact_type;
        $new_contact_type->save();
        return back()->with('success', 'Contact Type Created Successfully');

    }

    public function contact_type_update(Request $request)
    {
        $new_contact_type = contact_type::where('id', $request->contact_type_edit)->first();
        $new_contact_type->contact_type = $request->contact_type;
        $new_contact_type->save();
        return back()->with('success', 'Contact Type Updated Successfully');
    }


    public function contact_type_delete($id)
    {
        $delete_con_type = contact_type::where('id', $id)->first();
        $delete_con_type->delete();
        return back()->with('success', 'Contact Type Updated Successfully');
    }


    public function insurance()
    {
        $all_insurnace = insurance::where('admin_id', Auth::user()->id)->paginate(10);
        return view('admin.setting.insurance', compact('all_insurnace'));
    }

    public function insurance_save(Request $request)
    {
        $new_ins = new insurance();
        $new_ins->admin_id = Auth::user()->id;
        $new_ins->insurnace_name = $request->insurnace_name;
        $new_ins->insurnace_type = $request->insurnace_type;
        $new_ins->insurnace_practice_name = $request->insurnace_practice_name;
        $new_ins->insurnace_country = $request->insurnace_country;
        $new_ins->insurnace_city = $request->insurnace_city;
        $new_ins->insurnace_state = $request->insurnace_state;
        $new_ins->insurnace_contract = $request->insurnace_contract;
        $new_ins->insurnace_phone = $request->insurnace_phone;
        $new_ins->insurnace_email = $request->insurnace_email;
        $new_ins->save();
        return back()->with('success', 'Insurnace Created Successfully');
    }


    public function insurance_update(Request $request)
    {
        $new_ins = insurance::where('id', $request->insurnace_edit)->first();
        $new_ins->insurnace_name = $request->insurnace_name;
        $new_ins->insurnace_type = $request->insurnace_type;
        $new_ins->insurnace_practice_name = $request->insurnace_practice_name;
        $new_ins->insurnace_country = $request->insurnace_country;
        $new_ins->insurnace_city = $request->insurnace_city;
        $new_ins->insurnace_state = $request->insurnace_state;
        $new_ins->insurnace_contract = $request->insurnace_contract;
        $new_ins->insurnace_phone = $request->insurnace_phone;
        $new_ins->insurnace_email = $request->insurnace_email;
        $new_ins->save();
        return back()->with('success', 'Insurance Updated Successfully');
    }


    public function insurance_delete($id)
    {
        $delete_ins = insurance::where('id', $id)->first();
        $delete_ins->delete();
        return back()->with('success', 'Insurance Deleted Successfully');
    }


}
