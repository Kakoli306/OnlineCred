<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\provider_activity;
use App\Models\provider_address;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\provider_document;
use App\Models\provider_email;
use App\Models\Provider_info;
use App\Models\provider_online_access;
use App\Models\provider_phone;
use App\Models\provider_portal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminProviderController extends Controller
{



    public function provider_save(Request $request)
    {

        $new_provider = new Provider();
        $new_provider->admin_id = Auth::user()->id;
        $new_provider->full_name = $request->first_name.' '.$request->last_name;
        $new_provider->first_name = $request->first_name;
        $new_provider->last_name = $request->last_name;
        $new_provider->phone = $request->phone_num;
        $new_provider->dob = Carbon::parse($request->dob)->format('Y-m-d');
        $new_provider->gender = $request->gender;
        $new_provider->save();

        $proider_info = new Provider_info();
        $proider_info->admin_id = Auth::user()->id;
        $proider_info->provider_id = $new_provider->id;
        $proider_info->save();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_provider->id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Crated";
        $new_act->save();
        return back()->with('success','Provider Successfully Created');
    }


    public function provider_list()
    {
        $providers = Provider::where('admin_id',Auth::user()->id)->orderBy('id','desc')->paginate(20);
        return view('admin.provider.providerList',compact('providers'));
    }

    public function provider_info($id)
    {
        $provider = Provider::where('id',$id)->first();
        $provider_info = Provider_info::where('provider_id',$id)->first();
        $provider_phones = provider_phone::where('provider_id',$id)->get();
        $provider_emails = provider_email::where('provider_id',$id)->get();
        $provider_address = provider_address::where('provider_id',$id)->get();
        return view('admin.provider.providerInfo',compact('provider','provider_info','provider_phones','provider_emails','provider_address'));
    }

    public function provider_info_update(Request $request)
    {
        $proider = Provider::where('id',$request->provider_id)->first();
        $proider->full_name = $request->first_name.' '.$request->middle_name.' '.$request->last_name;
        $proider->first_name = $request->first_name;
        $proider->middle_name = $request->middle_name;
        $proider->last_name = $request->last_name;
        $proider->phone = $request->phone;
        $proider->dob = $request->dob;
        $proider->gender = $request->gender;
        $proider->email = $request->email;
        $proider->street = $request->street;
        $proider->city = $request->city;
        $proider->state = $request->state;
        $proider->zip = $request->zip;
        $proider->save();


        $provider_info = Provider_info::where('provider_id',$proider->id)->first();


        if($request->hasFile('sig_file')){
//            @unlink($provider_info->sig_file);
            $image = $request->file('sig_file');
            $imageName = uniqid().$provider_info->id.time().'.'.$image->getClientOriginalName('sig_file');
            $directory = 'assets/dashboard/signature/';
            $imgUrl  = $directory.$imageName;
            Image::make($image)->save($imgUrl);
            $provider_info->sig_file = $imgUrl;
        }

        $provider_info->suffix = $request->suffix;
        $provider_info->speciality = $request->speciality;
        $provider_info->tax_id = $request->tax_id;
        $provider_info->ssn = $request->ssn;
        $provider_info->npi = $request->npi;
        $provider_info->upin = $request->upin;
        $provider_info->dea = $request->dea;
        $provider_info->state_licence = $request->state_licence;
        $provider_info->patient_number = $request->patient_number;
        $provider_info->signature_date = $request->signature_date;
        $provider_info->signature_on_file = $request->signature_on_file;
        $provider_info->rp = $request->rp;
        $provider_info->ocp = $request->ocp;
        $provider_info->mp = $request->mp;
        $provider_info->anp = $request->anp;
        $provider_info->pdop = $request->pdop;
        $provider_info->app = $request->app;
        $provider_info->save();

        $data = $request->all();

        if (isset($data['edit_phone_id'])) {
            for ($i=0;$i<count($request->new_phone);$i++){
                provider_phone::updateOrCreate(['id'=>$data['edit_phone_id'][$i]],[
                    'admin_id'=>Auth::user()->id,
                    'provider_id'=>$proider->id,
                    'phone'=> isset($data['new_phone'][$i]) ? $data['new_phone'][$i] : null,
                ]);
            }
        }


        if (isset($data['edit_email_id'])) {
            for ($i=0;$i<count($request->new_email);$i++){
                provider_email::updateOrCreate(['id'=>$data['edit_email_id'][$i]],[
                    'admin_id'=>Auth::user()->id,
                    'provider_id'=>$proider->id,
                    'email'=> isset($data['new_email'][$i]) ? $data['new_email'][$i] : null,
                ]);
            }
        }


        if (isset($data['edit_address_id'])) {
            for ($i=0;$i<count($request->new_street);$i++){
                provider_address::updateOrCreate(['id'=>$data['edit_address_id'][$i]],[
                    'admin_id'=>Auth::user()->id,
                    'provider_id'=>$proider->id,
                    'street'=> isset($data['new_street'][$i]) ? $data['new_street'][$i] : null,
                    'city'=> isset($data['new_city'][$i]) ? $data['new_city'][$i] : null,
                    'state'=> isset($data['new_state'][$i]) ? $data['new_state'][$i] : null,
                    'zip'=> isset($data['new_zip'][$i]) ? $data['new_zip'][$i] : null,
                ]);
            }
        }


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $proider->id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Info Updated";
        $new_act->save();


        return back()->with('success','Provider Successfully Updated');

    }


    public function provider_info_exists_phone_delete(Request $request)
    {
        $delete_phon = provider_phone::where('id',$request->phonid)->first();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $delete_phon->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Phone Deleted";
        $new_act->save();

        $delete_phon->delete();
        return response()->json('done',200);
    }

    public function provider_info_exists_email_delete(Request $request)
    {
        $delete_email = provider_email::where('id',$request->emailid)->first();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $delete_email->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Email Deleted";
        $new_act->save();

        $delete_email->delete();
        return response()->json('done',200);
    }

    public function provider_info_exists_address_delete(Request $request)
    {
        $delete_address = provider_address::where('id',$request->addressid)->first();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $delete_address->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Address Deleted";
        $new_act->save();

        $delete_address->delete();
        return response()->json('done',200);
    }


    public function provider_contract($id)
    {
        $provider = Provider::where('id',$id)->first();
        $provider_contracts = provider_contract::where('admin_id',Auth::user()->id)->where('provider_id',$id)->orderBy('id','desc')->paginate(20);
        return view('admin.provider.providerContract',compact('provider','provider_contracts'));
    }


    public function provider_contract_save(Request $request)
    {
        $new_contract = new provider_contract();
        $new_contract->admin_id = Auth::user()->id;
        $new_contract->provider_id = $request->prvider_id;
        $new_contract->contract_name = $request->contract_name;
        $new_contract->onset_date = Carbon::parse($request->onset_date)->format('Y-m-d');
        $new_contract->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        $new_contract->contract_type = $request->contract_type;
        $new_contract->pin_no = $request->pin_no;
        $new_contract->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_contract->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Contract Created";
        $new_act->save();

        return back()->with('success','Provider Contract Successfully Created');
    }

    public function provider_contract_update(Request $request)
    {
        $update_contract = provider_contract::where('id',$request->contract_edit_id)->first();
        $update_contract->contract_name = $request->contract_name;
        $update_contract->onset_date = Carbon::parse($request->onset_date)->format('Y-m-d');
        $update_contract->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        $update_contract->contract_type = $request->contract_type;
        $update_contract->pin_no = $request->pin_no;
        $update_contract->save();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $update_contract->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Contract Updated";
        $new_act->save();

        return back()->with('success','Provider Contract Successfully Updated');
    }

    public function provider_contract_delete($id)
    {
        $delete_contract = provider_contract::where('id',$id)->first();
        if ($delete_contract) {


            $new_act = new provider_activity();
            $new_act->admin_id = Auth::user()->id;
            $new_act->provider_id = $delete_contract->provider_id;
            $new_act->created_by = Auth::user()->name;
            $new_act->message = "Provider Contract Deleted";
            $new_act->save();

            $delete_contract->delete();
            return back()->with('success','Provider Contract Successfully Deleted');
        }else{
            return back()->with('alert','Provider Contract Not Found');
        }
    }


    public function provider_contract_add_note(Request $request)
    {

        $new_note = new provider_contract_note();
        $new_note->admin_id = Auth::user()->id;
        $new_note->provider_id = $request->note_provider_id;
        $new_note->contract_id = $request->note_contract_id;
        $new_note->status = $request->status;
        $new_note->worked_date = $request->worked_date;
        $new_note->followup_date = $request->followup_date;
        $new_note->note = $request->note;
        $new_note->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_note->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Contract Note Added";
        $new_act->save();

        return back()->with('success','Provider Contract Note Successfully Added');
    }

    public function provider_contract_note_get(Request $request)
    {
        $note = provider_contract_note::where('admin_id',Auth::user()->id)->where('contract_id',$request->id)->get();
        return response()->json($note,200);
    }


    public function provider_document($id)
    {
        $provider = Provider::where('id',$id)->first();
        $provider_documents = provider_document::where('admin_id',Auth::user()->id)->where('provider_id',$id)->orderBy('id','desc')->paginate(20);
        return view('admin.provider.providerDocument',compact('provider','provider_documents'));
    }


    public function provider_document_save(Request $request)
    {
        $new_doc = new provider_document();
        if ($request->hasFile('doc_file')) {
            $image=$request->file('doc_file');
            $name=$image->getClientOriginalName();
            $uploadPath='assets/dashboard/documents/';
            $image->move($uploadPath,$name);
            $imageUrl=$uploadPath.$name;

            $new_doc->file = $imageUrl;
        }

        $new_doc->admin_id = Auth::user()->id;
        $new_doc->provider_id = $request->provider_id;
        $new_doc->doc_type = $request->doc_type;
        $new_doc->description = $request->description;
        $new_doc->exp_date = Carbon::parse($request->exp_date)->format('Y-m-d');
        $new_doc->created_by = Auth::user()->name;
        $new_doc->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_doc->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Document Added";
        $new_act->save();

        return back()->with('success','Provider Document Successfully Added');
    }

    public function provider_document_update(Request $request)
    {
        $update_doc = provider_document::where('id',$request->doc_edit_id)->first();
        if ($request->hasFile('doc_file')) {
//            unlink($update_doc->file);
            $image=$request->file('doc_file');
            $name=$image->getClientOriginalName();
            $uploadPath='assets/dashboard/documents/';
            $image->move($uploadPath,$name);
            $imageUrl=$uploadPath.$name;

            $update_doc->file = $imageUrl;
        }
        $update_doc->doc_type = $request->doc_type;
        $update_doc->description = $request->description;
        $update_doc->exp_date = Carbon::parse($request->exp_date)->format('Y-m-d');
        $update_doc->created_by = Auth::user()->name;
        $update_doc->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $update_doc->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Document Updated";
        $new_act->save();

        return back()->with('success','Provider Document Successfully Updated');
    }

    public function provider_document_delete($id)
    {
        $delete_doc = provider_document::where('id',$id)->first();
        if ($delete_doc) {
//            unlink($delete_doc->file);

            $new_act = new provider_activity();
            $new_act->admin_id = Auth::user()->id;
            $new_act->provider_id = $delete_doc->provider_id;
            $new_act->created_by = Auth::user()->name;
            $new_act->message = "Provider Document Deleted";
            $new_act->save();

            $delete_doc->delete();
            return back()->with('success','Provider Document Successfully Deleted');
        }else{
            return back()->with('alert','Provider Document Not Found');
        }
    }


    public function provider_portal($id)
    {
        $provider = Provider::where('id',$id)->first();
        $check_provider_portal = provider_portal::where('admin_id',Auth::user()->id)->where('provider_id',$id)->first();
        $provider_all_email = provider_email::where('provider_id',$id)->get();
        if ($check_provider_portal) {
            $portal = $check_provider_portal;
        }else{
            $portal = new provider_portal();
            $portal->admin_id = Auth::user()->id;
            $portal->provider_id = $id;
            $portal->save();
        }
        return view('admin.provider.providerPortal',compact('provider','portal','provider_all_email'));
    }

    public function provider_portal_save(Request $request)
    {
        $portal = provider_portal::where('id',$request->portal_edit_id)->first();
        $portal->sec_msg = $request->sec_msg;
        $portal->acc_bill = $request->acc_bill;
        $portal->pay_bal = $request->pay_bal;
        $portal->save();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $portal->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Portal Updated";
        $new_act->save();

        return back()->with('success','Provider Portal Successfully Updated');
    }

    public function provider_online_access($id)
    {
        $provider = Provider::where('id',$id)->first();
        $provider_online_access = provider_online_access::where('admin_id',Auth::user()->id)->where('provider_id',$id)->paginate(20);
        return view('admin.provider.providerOnlineAccess',compact('provider','provider_online_access'));
    }

    public function provider_online_access_save(Request $request)
    {
        $new_access = new provider_online_access();
        $new_access->admin_id = Auth::user()->id;
        $new_access->provider_id = $request->provider_id;
        $new_access->name = $request->name;
        $new_access->url = $request->url;
        $new_access->user_name = $request->user_name;
        $new_access->password = $request->password;
        $new_access->save();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_access->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Online Access Created";
        $new_act->save();

        return back()->with('success','Provider Online Access Successfully Created');
    }

    public function provider_tracking_user($id)
    {
        $provider = Provider::where('id',$id)->first();
        return view('admin.provider.providerTrackingUser',compact('provider'));
    }

    public function provider_activity($id)
    {
        $provider = Provider::where('id',$id)->first();
        return view('admin.provider.providerActivity',compact('provider'));
    }

    public function get_all_provider(Request $request)
    {
        $all_provider = Provider::all();
        return response()->json($all_provider,200);
    }



}
