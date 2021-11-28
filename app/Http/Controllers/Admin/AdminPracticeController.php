<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\assign_practice;
use App\Models\practice;
use App\Models\Provider;
use App\Models\speciality;
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

        if ($request->hasFile('doc_file')) {

            if (!empty($update_prac->doc_file) && file_exists($update_prac->doc_file)) {
                unlink($update_prac->doc_file);
            }

            $image=$request->file('doc_file');
            $name=$image->getClientOriginalName();
            $uploadPath='assets/dashboard/providerdoc/';
            $image->move($uploadPath,$name);
            $imageUrl=$uploadPath.$name;

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


    public function practice_assign()
    {
        return view('admin.facility.facilityAssign');
    }


    public function practice_get_all(Request $request)
    {
        $prac = assign_practice::where('provider_id',$request->pro_id)->get();
        $ids = [];
        foreach ($prac as $prc){
            array_push($ids,$prc->practice_id);
        }

        $all_practice = practice::whereNotIn('id',$ids )->get();
        return response()->json($all_practice,200);
    }

    public function practice_assign_get(Request $request)
    {
        $prac = assign_practice::where('provider_id',$request->pro_id)->get();
        $ids = [];
        foreach ($prac as $prc){
            array_push($ids,$prc->practice_id);
        }

        $get_all_prac = practice::whereIn('id',$ids)->get();
        return response()->json($get_all_prac,200);

    }


    public function practice_add_provider(Request $request)
    {
        $fac_ids = $request->fac_id;
        $provder_id = $request->pro_id;
        $checkprc = assign_practice::where('admin_id',Auth::user()->id)->where('provider_id',$provder_id)->count();
        if (count($fac_ids) > 1) {
            return response()->json('more_prc',200);
        }elseif ($checkprc >= 1){
            return response()->json('already_have',200);
        }else{
            for ($i=0;$i<count($fac_ids);$i++){
                assign_practice::create([
                    'admin_id' => Auth::user()->id,
                    'provider_id' => $provder_id,
                    'practice_id' => $fac_ids[$i],
                ]);
            }

            return response()->json('done',200);
        }



    }

    public function practice_remove_provider(Request $request)
    {
        $assign_prac = $request->assign_prac;
        $pro_id = $request->pro_id;

        foreach ($assign_prac as $prc ){
            $del_ass_prc = assign_practice::where('admin_id',Auth::user()->id)->where('provider_id',$pro_id)->where('practice_id',$prc)->first();
            if ($del_ass_prc) {
                $del_ass_prc->delete();
            }
        }
        return response()->json('done',200);

    }










}
