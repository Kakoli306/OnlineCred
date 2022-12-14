<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use App\Mail\AccessEmail;
use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\BaseStaff;
use App\Models\contact_name;
use App\Models\contact_type;
use App\Models\contract_status;
use App\Models\portal_access_email;
use App\Models\Provider;
use App\Models\provider_activity;
use App\Models\provider_address;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\provider_document;
use App\Models\provider_document_type;
use App\Models\provider_email;
use App\Models\Provider_info;
use App\Models\provider_insurance_document;
use App\Models\provider_online_access;
use App\Models\provider_phone;
use App\Models\provider_portal;
use App\Models\reminder;
use App\Models\speciality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

class AccManProviderController extends Controller
{
    public function provider()
    {

        return view('accountManager.provider.providerList');
    }

    public function provider_save(Request $request)
    {
        $new_provider = new Provider();
        $new_provider->practice_id = $request->fac_id;
        $new_provider->full_name = $request->first_name . ' ' . $request->last_name;
        $new_provider->first_name = $request->first_name;
        $new_provider->last_name = $request->last_name;
        $new_provider->phone = $request->phone_num;
        $new_provider->dob = Carbon::parse($request->dob)->format('Y-m-d');
        $new_provider->gender = $request->gender;
        $new_provider->age_restriction = $request->age_restriction;
        $new_provider->working_hours = $request->working_hours;
        $new_provider->country_name = $request->country_name;
        $new_provider->contract_manager = $request->contract_manager;
        $new_provider->save();

        $proider_info = new Provider_info();
        $proider_info->admin_id = Auth::user()->id;
        $proider_info->provider_id = $new_provider->id;
        $proider_info->save();

        $new_act = new provider_activity();
        $new_act->provider_id = $new_provider->id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Crated";
        $new_act->save();
        return response()->json('done', 200);
    }


    public function provider_list_by_fid(Request $request)
    {


        $fid = $request->f_id;
        $search_name = $request->search_name;
        $search_tax = $request->search_tax;
        $search_npi = $request->search_npi;
//        $query = "SELECT * FROM providers WHERE id IS NOT NULL ";
        $query = "SELECT providers.id,providers.practice_id,providers.full_name,providers.phone,providers.dob,providers.gender,providers.is_active FROM providers ";
        $query .= "LEFT JOIN provider_infos ON providers.id = provider_infos.provider_id ";
        $query .= "WHERE providers.id IS NOT NULL ";

        if (isset($fid) && $fid != 0) {
            $query .= "AND providers.practice_id=$fid ";
        }

        if (isset($search_name)) {
            if ($search_name != null || $search_name != "") {
                $query .= "AND providers.full_name LIKE '%$search_name%' ";
            }

        }

        if (isset($search_tax)) {
            if ($search_tax != null || $search_tax != "") {
                $query .= "AND provider_infos.tax_id LIKE '%$search_tax%' ";
            }

        }


        if (isset($search_npi)) {
            if ($search_npi != null || $search_npi != "") {
                $query .= "AND provider_infos.npi LIKE '%$search_npi%' ";
            }

        }

        $query .= "ORDER BY providers.full_name ASC";


        $query_exe = DB::select($query);

        $providers = $this->arrayPaginator($query_exe, $request);
        return response()->json([
            'notices' => $providers,
            'view' => View::make('accountManager.provider.include.providerlistfid', compact('providers'))->render(),
            'pagination' => (string)$providers->links()
        ]);
    }


    public function provider_list_by_fid_get(Request $request)
    {
        $fid = $request->f_id;
        $search_name = $request->search_name;
        $search_tax = $request->search_tax;
        $search_npi = $request->search_npi;
//        $query = "SELECT * FROM providers WHERE id IS NOT NULL ";
        $query = "SELECT providers.id,providers.practice_id,providers.full_name,providers.phone,providers.dob,providers.gender,providers.is_active FROM providers ";
        $query .= "LEFT JOIN provider_infos ON providers.id = provider_infos.provider_id ";
        $query .= "WHERE providers.id IS NOT NULL ";

        if (isset($fid) && $fid != 0) {
            $query .= "AND providers.practice_id=$fid ";
        }

        if (isset($search_name)) {
            if ($search_name != null || $search_name != "") {
                $query .= "AND providers.full_name LIKE '%$search_name%' ";
            }

        }

        if (isset($search_tax)) {
            if ($search_tax != null || $search_tax != "") {
                $query .= "AND provider_infos.tax_id LIKE '%$search_tax%' ";
            }

        }


        if (isset($search_npi)) {
            if ($search_npi != null || $search_npi != "") {
                $query .= "AND provider_infos.npi LIKE '%$search_npi%' ";
            }

        }

        $query .= "ORDER BY providers.full_name ASC";


        $query_exe = DB::select($query);

        $providers = $this->arrayPaginator($query_exe, $request);
        return response()->json([
            'notices' => $providers,
            'view' => View::make('accountManager.provider.include.providerlistfid', compact('providers'))->render(),
            'pagination' => (string)$providers->links()
        ]);
    }


    public function provider_list_by_faiclity($id)
    {
        $providers = Provider::orderBy('id', 'desc')->paginate(20);
        $facility_id = $id;
        return view('accountManager.provider.providerListFacility', compact('providers', 'facility_id'));
    }


    public function provider_info($id)
    {
        $provider = Provider::where('id', $id)->first();
        $provider_info = Provider_info::where('provider_id', $id)->first();
        $provider_phones = provider_phone::where('provider_id', $id)->get();
        $provider_emails = provider_email::where('provider_id', $id)->get();
        $provider_address = provider_address::where('provider_id', $id)->get();
        $spec = speciality::all();
        return view('accountManager.provider.providerInfo', compact('provider', 'provider_info', 'provider_phones', 'provider_emails', 'provider_address', 'spec'));
    }


    public function provider_info_update(Request $request)
    {
        $proider = Provider::where('id', $request->provider_id)->first();
        $proider->is_active = $request->is_active;
        $proider->full_name = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        $proider->first_name = $request->first_name;
        $proider->middle_name = $request->middle_name;
        $proider->last_name = $request->last_name;
        $proider->phone = $request->phone;
        $proider->dob = $request->dob;
        $proider->gender = $request->gender;
        $proider->email = $request->email;
        $proider->address_name = $request->address_name;
        $proider->street = $request->street;
        $proider->city = $request->city;
        $proider->state = $request->state;
        $proider->zip = $request->zip;
        $proider->age_restriction = $request->age_restriction;
        $proider->working_hours = $request->working_hours;
        $proider->country_name = $request->country_name;
        $proider->contract_manager = $request->contract_manager;
        $proider->caqh_id = $request->caqh_id;
        $proider->save();


        $provider_info = Provider_info::where('provider_id', $proider->id)->first();


        if ($request->hasFile('sig_file')) {
//            @unlink($provider_info->sig_file);
            $image = $request->file('sig_file');
            $imageName = uniqid() . $provider_info->id . time() . '.' . $image->getClientOriginalName('sig_file');
            $directory = 'assets/dashboard/signature/';
            $imgUrl = $directory . $imageName;
            Image::make($image)->save($imgUrl);
            $provider_info->sig_file = $imgUrl;
        }

        $provider_info->suffix = $request->suffix;
        $provider_info->speciality = $request->speciality;
        $provider_info->taxonomy_code = $request->taxonomy_code;
        $provider_info->tax_id = $request->tax_id;
        $provider_info->ssn = $request->ssn;
        $provider_info->npi = $request->npi;
        $provider_info->upin = $request->upin;
        $provider_info->dea = $request->dea;
        $provider_info->state_licence = $request->state_licence;
        $provider_info->medicare_ptan = $request->medicare_ptan;
        $provider_info->medicare_id = $request->medicare_id;
        $provider_info->fax_number = $request->fax_number;
        $provider_info->signature_date = $request->signature_date;
        $provider_info->start_date = $request->start_date;
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
            for ($i = 0; $i < count($request->new_phone); $i++) {
                provider_phone::updateOrCreate(['id' => $data['edit_phone_id'][$i]], [
                    'admin_id' => Auth::user()->id,
                    'provider_id' => $proider->id,
                    'phone' => isset($data['new_phone'][$i]) ? $data['new_phone'][$i] : null,
                ]);
            }
        }


        if (isset($data['edit_email_id'])) {
            for ($i = 0; $i < count($request->new_email); $i++) {
                provider_email::updateOrCreate(['id' => $data['edit_email_id'][$i]], [
                    'admin_id' => Auth::user()->id,
                    'provider_id' => $proider->id,
                    'email' => isset($data['new_email'][$i]) ? $data['new_email'][$i] : null,
                ]);
            }
        }


        if (isset($data['edit_address_id'])) {
            for ($i = 0; $i < count($request->new_street); $i++) {
                provider_address::updateOrCreate(['id' => $data['edit_address_id'][$i]], [
                    'admin_id' => Auth::user()->id,
                    'provider_id' => $proider->id,
                    'address_name' => isset($data['new_address_name'][$i]) ? $data['new_address_name'][$i] : null,
                    'street' => isset($data['new_street'][$i]) ? $data['new_street'][$i] : null,
                    'city' => isset($data['new_city'][$i]) ? $data['new_city'][$i] : null,
                    'state' => isset($data['new_state'][$i]) ? $data['new_state'][$i] : null,
                    'zip' => isset($data['new_zip'][$i]) ? $data['new_zip'][$i] : null,
                ]);
            }
        }


        $new_act = new provider_activity();
        $new_act->provider_id = $proider->id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Info Updated";
        $new_act->save();


        return back()->with('success', 'Provider Successfully Updated');
    }


    public function provider_info_exists_phone_delete(Request $request)
    {
        $delete_phon = provider_phone::where('id', $request->phonid)->first();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $delete_phon->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Phone Deleted";
        $new_act->save();

        $delete_phon->delete();
        return response()->json('done', 200);
    }

    public function provider_info_exists_email_delete(Request $request)
    {
        $delete_email = provider_email::where('id', $request->emailid)->first();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $delete_email->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Email Deleted";
        $new_act->save();

        $delete_email->delete();
        return response()->json('done', 200);
    }

    public function provider_info_exists_address_delete(Request $request)
    {
        $delete_address = provider_address::where('id', $request->addressid)->first();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $delete_address->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Address Deleted";
        $new_act->save();

        $delete_address->delete();
        return response()->json('done', 200);
    }


    public function provider_contract($id)
    {
        $provider = Provider::where('id', $id)->first();
        $provider_contracts = provider_contract::where('provider_id', $id)->orderBy('id', 'desc')->paginate(20);
        $contact_name = contact_name::all();
        $contact_type = contact_type::all();
        $contact_status = contract_status::all();
        return view('accountManager.provider.providerContract', compact('provider', 'provider_contracts', 'contact_name', 'contact_type', 'contact_status'));
    }

    public function provider_contract_save(Request $request)
    {
        $prov_prac = Provider::where('id', $request->prvider_id)
            ->first();

        $new_contract = new provider_contract();
        if ($request->hasFile('contact_document')) {
            $image = $request->file('contact_document');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document = $imageUrl;
        }


        if ($request->hasFile('contact_document_one')) {
            $image = $request->file('contact_document_one');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document_one = $imageUrl;
        }

        if ($request->hasFile('contact_document_two')) {
            $image = $request->file('contact_document_two');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document_two = $imageUrl;
        }

        if ($request->hasFile('contact_document_three')) {
            $image = $request->file('contact_document_three');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document_three = $imageUrl;
        }

        if ($request->hasFile('contact_document_four')) {
            $image = $request->file('contact_document_four');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document_four = $imageUrl;
        }

        if ($request->hasFile('contact_document_five')) {
            $image = $request->file('contact_document_five');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document_five = $imageUrl;
        }

        if ($request->hasFile('contact_document_six')) {
            $image = $request->file('contact_document_six');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_contract->contact_document_six = $imageUrl;
        }

        $new_contract->admin_id = Auth::user()->id;
        $new_contract->facility_id = $prov_prac->practice_id;
        $new_contract->provider_id = $request->prvider_id;
        $new_contract->contract_name = $request->contract_name;
        if ($request->onset_date != null || $request->onset_date != "") {
            $new_contract->onset_date = Carbon::parse($request->onset_date)->format('Y-m-d');
        } else {
            $new_contract->onset_date = null;
        }

        if ($request->end_date != null || $request->end_date != "") {
            $new_contract->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        } else {
            $new_contract->end_date = null;
        }
        if ($request->contract_followup_date != null || $request->contract_followup_date != "") {
            $new_contract->contract_followup_date = Carbon::parse($request->contract_followup_date)->format('Y-m-d');
        } else {
            $new_contract->contract_followup_date = Carbon::now()->format('Y-m-d');
        }
        $new_contract->contract_type = $request->contract_type;
        $new_contract->status = $request->con_status;


        if ($request->assign_to_name != null || $request->assign_to_name != "") {
            $admin_user = Admin::where('name', $request->assign_to_name)->first();
            $manager_user = AccountManager::where('name', $request->assign_to_name)->first();
            $staff_user = BaseStaff::where('name', $request->assign_to_name)->first();

            if ($admin_user) {
                $new_contract->assign_to_name = $admin_user->name;
                $new_contract->assign_to_id = $admin_user->id;
                $new_contract->assign_to_type = $admin_user->account_type;
            }

            if ($manager_user) {
                $new_contract->assign_to_name = $manager_user->name;
                $new_contract->assign_to_id = $manager_user->id;
                $new_contract->assign_to_type = $manager_user->account_type;
            }

            if ($staff_user) {
                $new_contract->assign_to_name = $staff_user->name;
                $new_contract->assign_to_id = $staff_user->id;
                $new_contract->assign_to_type = $staff_user->account_type;
            }
            $new_contract->is_assign = 1;
        } else {
            $new_contract->assign_to_name = 0;
            $new_contract->assign_to_id = 0;
            $new_contract->assign_to_type = 0;
            $new_contract->is_assign = 0;
        }


        $new_contract->save();

        $status_data = contract_status::where('id', $new_contract->status)->first();

        $new_reminder_user = new reminder();
        $new_reminder_user->user_id = Auth::user()->id;
        $new_reminder_user->user_type = Auth::user()->account_type;
        $new_reminder_user->provider_id = $new_contract->provider_id;
        $new_reminder_user->facility_id = $new_contract->facility_id;
        $new_reminder_user->contract_id = $new_contract->id;
        $new_reminder_user->note_id = 0;
        $new_reminder_user->followup_date = $new_contract->contract_followup_date;
        $new_reminder_user->worked_date = null;
        $new_reminder_user->status = $new_contract->status;
        $new_reminder_user->is_note = 0;
        if ($request->assign_to_name != null || $request->assign_to_name != "") {

            $admin_user = Admin::where('name', $request->assign_to_name)->first();
            $manager_user = AccountManager::where('name', $request->assign_to_name)->first();
            $staff_user = BaseStaff::where('name', $request->assign_to_name)->first();

            $new_reminder_user->is_assign = 1;
            if ($admin_user) {
                $new_reminder_user->assignedto_user_id = $admin_user->id;
                $new_reminder_user->assignedto_user_type = $admin_user->account_type;
            }

            if ($manager_user) {
                $new_reminder_user->assignedto_user_id = $manager_user->id;
                $new_reminder_user->assignedto_user_type = $manager_user->account_type;
            }

            if ($staff_user) {
                $new_reminder_user->assignedto_user_id = $staff_user->id;
                $new_reminder_user->assignedto_user_type = $staff_user->account_type;
            }

        } else {
            $new_reminder_user->is_assign = 0;
            $new_reminder_user->assignedto_user_id = 0;
            $new_reminder_user->assignedto_user_type = 0;
        }
        $new_reminder_user->is_show = isset($status_data) ? $status_data->is_show_reminder : 0;
        $new_reminder_user->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_contract->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Contract Created";
        $new_act->save();

        return back()->with('success', 'Provider Contract Successfully Created');
    }


    public function provider_contract_update(Request $request)
    {
        $update_contract = provider_contract::where('id', $request->contract_edit_id)->first();


        if ($request->hasFile('contact_document')) {

            if (file_exists($update_contract->contact_document)) {
                unlink($update_contract->contact_document);
            }
            $image = $request->file('contact_document');
            $name = $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document = $imageUrl;
        }


        if ($request->hasFile('contact_document_one')) {
            $image = $request->file('contact_document_one');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document_one = $imageUrl;
        }

        if ($request->hasFile('contact_document_two')) {
            $image = $request->file('contact_document_two');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document_two = $imageUrl;
        }

        if ($request->hasFile('contact_document_three')) {
            $image = $request->file('contact_document_three');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document_three = $imageUrl;
        }

        if ($request->hasFile('contact_document_four')) {
            $image = $request->file('contact_document_four');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document_four = $imageUrl;
        }

        if ($request->hasFile('contact_document_five')) {
            $image = $request->file('contact_document_five');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document_five = $imageUrl;
        }

        if ($request->hasFile('contact_document_six')) {
            $image = $request->file('contact_document_six');
            $name = uniqid() . time() . $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/contacts/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_contract->contact_document_six = $imageUrl;
        }


        $update_contract->contract_name = $request->contract_name;
        if ($request->onset_date != null || $request->onset_date != "") {
            $update_contract->onset_date = Carbon::parse($request->onset_date)->format('Y-m-d');
        } elseif ($request->onset_date == null || $request->onset_date == "") {
            $update_contract->onset_date = null;
        } else {
            $update_contract->onset_date = $update_contract->onset_date;
        }


        if ($request->end_date != null || $request->end_date != "") {
            $update_contract->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        } elseif ($request->end_date == null || $request->end_date == "") {
            $update_contract->end_date = null;
        } else {
            $update_contract->end_date = $update_contract->end_date;
        }

        if ($request->contract_followup_date != null || $request->contract_followup_date != "") {
            $update_contract->contract_followup_date = Carbon::parse($request->contract_followup_date)->format('Y-m-d');
        } else {
            $update_contract->contract_followup_date = $update_contract->contract_followup_date;
        }

        $update_contract->contract_type = $request->contract_type;
        $update_contract->status = $request->con_status;

        if ($request->assign_to_name != null || $request->assign_to_name != "") {
            $admin_user = Admin::where('name', $request->assign_to_name)->first();
            $manager_user = AccountManager::where('name', $request->assign_to_name)->first();
            $staff_user = BaseStaff::where('name', $request->assign_to_name)->first();

            if ($admin_user) {
                $update_contract->assign_to_name = $admin_user->name;
                $update_contract->assign_to_id = $admin_user->id;
                $update_contract->assign_to_type = $admin_user->account_type;
            }

            if ($manager_user) {
                $update_contract->assign_to_name = $manager_user->name;
                $update_contract->assign_to_id = $manager_user->id;
                $update_contract->assign_to_type = $manager_user->account_type;
            }

            if ($staff_user) {
                $update_contract->assign_to_name = $staff_user->name;
                $update_contract->assign_to_id = $staff_user->id;
                $update_contract->assign_to_type = $staff_user->account_type;
            }

            $update_contract->is_assign = 1;

        } else {
            $update_contract->assign_to_name = 0;
            $update_contract->assign_to_id = 0;
            $update_contract->assign_to_type = 0;
            $update_contract->is_assign = 0;
        }


        $update_contract->save();

        $status_data = contract_status::where('id', $update_contract->status)->first();
        $update_reminder_user = reminder::where('contract_id', $update_contract->id)
            ->first();

        if ($update_reminder_user) {
            $update_reminder_user->provider_id = $update_contract->provider_id;
            $update_reminder_user->facility_id = $update_contract->facility_id;
            $update_reminder_user->contract_id = $update_contract->id;
            $update_reminder_user->note_id = 0;
            $update_reminder_user->followup_date = $update_contract->contract_followup_date;
            $update_reminder_user->worked_date = null;
            $update_reminder_user->status = $update_contract->status;
            $update_reminder_user->is_note = 0;
            if ($request->assign_to_name != null || $request->assign_to_name != "") {


                $admin_user = Admin::where('name', $request->assign_to_name)->first();
                $manager_user = AccountManager::where('name', $request->assign_to_name)->first();
                $staff_user = BaseStaff::where('name', $request->assign_to_name)->first();
                $update_reminder_user->is_assign = 1;
                if ($admin_user) {
                    $update_reminder_user->assignedto_user_id = $admin_user->id;
                    $update_reminder_user->assignedto_user_type = $admin_user->account_type;
                }

                if ($manager_user) {
                    $update_reminder_user->assignedto_user_id = $manager_user->id;
                    $update_reminder_user->assignedto_user_type = $manager_user->account_type;
                }

                if ($staff_user) {
                    $update_reminder_user->assignedto_user_id = $staff_user->id;
                    $update_reminder_user->assignedto_user_type = $staff_user->account_type;
                }
            } else {
                $update_reminder_user->is_assign = 0;
                $update_reminder_user->assignedto_user_id = 0;
                $update_reminder_user->assignedto_user_type = 0;
            }
            $update_reminder_user->is_show = isset($status_data) ? $status_data->is_show_reminder : 0;
            $update_reminder_user->save();
        } else {
            $new_reminder_user = new reminder();
            $new_reminder_user->provider_id = $update_contract->provider_id;
            $new_reminder_user->facility_id = $update_contract->facility_id;
            $new_reminder_user->contract_id = $update_contract->id;
            $new_reminder_user->note_id = 0;
            $new_reminder_user->followup_date = $update_contract->contract_followup_date;
            $new_reminder_user->worked_date = null;
            $new_reminder_user->status = $update_contract->status;
            $new_reminder_user->is_note = 0;

            if ($request->assign_to_name != null || $request->assign_to_name != "") {


                $admin_user = Admin::where('name', $request->assign_to_name)->first();
                $manager_user = AccountManager::where('name', $request->assign_to_name)->first();
                $staff_user = BaseStaff::where('name', $request->assign_to_name)->first();
                $new_reminder_user->is_assign = 1;
                if ($admin_user) {
                    $new_reminder_user->assignedto_user_id = $admin_user->id;
                    $new_reminder_user->assignedto_user_type = $admin_user->account_type;
                }

                if ($manager_user) {
                    $new_reminder_user->assignedto_user_id = $manager_user->id;
                    $new_reminder_user->assignedto_user_type = $manager_user->account_type;
                }

                if ($staff_user) {
                    $new_reminder_user->assignedto_user_id = $staff_user->id;
                    $new_reminder_user->assignedto_user_type = $staff_user->account_type;
                }
            } else {
                $new_reminder_user->is_assign = 0;
                $new_reminder_user->assignedto_user_id = 0;
                $new_reminder_user->assignedto_user_type = 0;
            }
            $new_reminder_user->is_show = isset($status_data) ? $status_data->is_show_reminder : 0;
            $new_reminder_user->save();
        }


        $new_act = new provider_activity();
        $new_act->provider_id = $update_contract->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Contract Updated";
        $new_act->save();

        return back()->with('success', 'Provider Contract Successfully Updated');
    }


    public function provider_contract_delete($id)
    {
        $delete_contract = provider_contract::where('id', $id)->first();
        if ($delete_contract) {


            $new_act = new provider_activity();
            $new_act->admin_id = Auth::user()->id;
            $new_act->provider_id = $delete_contract->provider_id;
            $new_act->created_by = Auth::user()->name;
            $new_act->message = "Provider Contract Deleted";
            $new_act->save();

            $delete_contract->delete();
            return back()->with('success', 'Provider Contract Successfully Deleted');
        } else {
            return back()->with('alert', 'Provider Contract Not Found');
        }
    }


    public function provider_contract_add_note(Request $request)
    {
        $con_details = provider_contract::where('id', $request->note_contract_id)->first();

        $new_note = new provider_contract_note();
        $new_note->user_id = Auth::user()->id;
        $new_note->user_type = Auth::user()->account_type;
        $new_note->user_name = Auth::user()->name;
        $new_note->provider_id = $request->note_provider_id;
        $new_note->facility_id = $con_details->facility_id;
        $new_note->contract_id = $request->note_contract_id;
        $new_note->contract_name = $con_details->contract_name;
        $new_note->status = $request->note_status;
        $new_note->worked_date = $request->worked_date;
        $new_note->followup_date = $request->followup_date;
        $new_note->note = $request->note;
        $new_note->save();


        $status_data = contract_status::where('id', $new_note->status)->first();

        $contract_data = provider_contract::where('id', $new_note->contract_id)->first();
        if ($request->note_assign_to_name != null || $request->note_assign_to_name != "") {

            $admin_user = Admin::where('name', $request->note_assign_to_name)->first();
            $manager_user = AccountManager::where('name', $request->note_assign_to_name)->first();
            $staff_user = BaseStaff::where('name', $request->note_assign_to_name)->first();
            if ($admin_user) {
                $contract_data->assign_to_name = $admin_user->name;
                $contract_data->assign_to_id = $admin_user->id;
                $contract_data->assign_to_type = $admin_user->account_type;
            }

            if ($manager_user) {
                $contract_data->assign_to_name = $manager_user->name;
                $contract_data->assign_to_id = $manager_user->id;
                $contract_data->assign_to_type = $manager_user->account_type;
            }

            if ($staff_user) {
                $contract_data->assign_to_name = $staff_user->name;
                $contract_data->assign_to_id = $staff_user->id;
                $contract_data->assign_to_type = $staff_user->account_type;
            }

            $contract_data->is_assign = 1;

        } else {
            $contract_data->assign_to_name = $contract_data->assign_to_name;
            $contract_data->assign_to_id = $contract_data->assign_to_id;
            $contract_data->assign_to_type = $contract_data->assign_to_type;
            $contract_data->is_assign = $contract_data->is_assign;
        }
        if ($new_note->followup_date != null || $new_note->followup_date != "") {
            $contract_data->contract_followup_date = $new_note->followup_date;
        } else {
            $contract_data->contract_followup_date = $contract_data->contract_followup_date;
        }
        $contract_data->status = $new_note->status;
        $contract_data->save();

        $exist_reminder = reminder::where('contract_id', $new_note->contract_id)->first();


        if ($exist_reminder) {
            $new_reminder_user = reminder::where('contract_id', $new_note->contract_id)
//                ->where('assignedto_user_id', $user_id)
//                ->where('assignedto_user_type', $user_type)
                ->first();
            $new_reminder_user->user_id = Auth::user()->id;
            $new_reminder_user->user_type = Auth::user()->account_type;
            $new_reminder_user->provider_id = $new_note->provider_id;
            $new_reminder_user->facility_id = $new_note->facility_id;
            $new_reminder_user->contract_id = $new_note->contract_id;
            $new_reminder_user->note_id = $new_note->id;
            $new_reminder_user->followup_date = $new_note->followup_date;
            $new_reminder_user->worked_date = $new_note->worked_date;
            $new_reminder_user->status = $new_note->status;
            $new_reminder_user->is_note = 1;
            if ($request->note_assign_to_name != null || $request->note_assign_to_name != "") {


                $admin_user = Admin::where('name', $request->note_assign_to_name)->first();
                $manager_user = AccountManager::where('name', $request->note_assign_to_name)->first();
                $staff_user = BaseStaff::where('name', $request->note_assign_to_name)->first();
                $new_reminder_user->is_assign = 1;
                if ($admin_user) {
                    $new_reminder_user->assignedto_user_id = $admin_user->id;
                    $new_reminder_user->assignedto_user_type = $admin_user->account_type;
                }

                if ($manager_user) {
                    $new_reminder_user->assignedto_user_id = $manager_user->id;
                    $new_reminder_user->assignedto_user_type = $manager_user->account_type;
                }

                if ($staff_user) {
                    $new_reminder_user->assignedto_user_id = $staff_user->id;
                    $new_reminder_user->assignedto_user_type = $staff_user->account_type;
                }
            } else {
                $new_reminder_user->is_assign = 0;
                $new_reminder_user->assignedto_user_id = 0;
                $new_reminder_user->assignedto_user_type = 0;
            }
            $new_reminder_user->is_show = isset($status_data) ? $status_data->is_show_reminder : 0;
            $new_reminder_user->save();
        } else {
            $new_reminder_user = new reminder();
            $new_reminder_user->user_id = Auth::user()->id;
            $new_reminder_user->user_type = Auth::user()->account_type;
            $new_reminder_user->provider_id = $new_note->provider_id;
            $new_reminder_user->facility_id = $new_note->facility_id;
            $new_reminder_user->contract_id = $new_note->contract_id;
            $new_reminder_user->note_id = $new_note->id;
            $new_reminder_user->followup_date = $new_note->followup_date;
            $new_reminder_user->worked_date = $new_note->worked_date;
            $new_reminder_user->status = $new_note->status;
            $new_reminder_user->is_note = 1;
            if ($request->note_assign_to_name != null || $request->note_assign_to_name != "") {


                $admin_user = Admin::where('name', $request->note_assign_to_name)->first();
                $manager_user = AccountManager::where('name', $request->note_assign_to_name)->first();
                $staff_user = BaseStaff::where('name', $request->note_assign_to_name)->first();
                $new_reminder_user->is_assign = 1;
                if ($admin_user) {
                    $new_reminder_user->assignedto_user_id = $admin_user->id;
                    $new_reminder_user->assignedto_user_type = $admin_user->account_type;
                }

                if ($manager_user) {
                    $new_reminder_user->assignedto_user_id = $manager_user->id;
                    $new_reminder_user->assignedto_user_type = $manager_user->account_type;
                }

                if ($staff_user) {
                    $new_reminder_user->assignedto_user_id = $staff_user->id;
                    $new_reminder_user->assignedto_user_type = $staff_user->account_type;
                }
            } else {
                $new_reminder_user->is_assign = 0;
                $new_reminder_user->assignedto_user_id = 0;
                $new_reminder_user->assignedto_user_type = 0;
            }
            $new_reminder_user->is_show = isset($status_data) ? $status_data->is_show_reminder : 0;
            $new_reminder_user->save();
        }


        $new_act = new provider_activity();
        $new_act->provider_id = $new_note->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Contract Note Added";
        $new_act->save();

        return back()->with('success', 'Provider Contract Note Successfully Added');
    }


    public function provider_contract_note_get(Request $request)
    {
        $note = provider_contract_note::where('contract_id', $request->id)->get();
        return response()->json($note, 200);
    }


    public function provider_document($id)
    {
        $provider = Provider::where('id', $id)->first();
        $provider_documents = provider_document::where('provider_id', $id)->orderBy('id', 'desc')->paginate(20);
        $providers_doc_type = provider_document_type::all();
        return view('accountManager.provider.providerDocument', compact('provider', 'provider_documents', 'providers_doc_type'));
    }


    public function provider_document_save(Request $request)
    {
        $new_doc = new provider_document();
        if ($request->hasFile('doc_file')) {
            $image = $request->file('doc_file');
            $name = $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/documents/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_doc->file = $imageUrl;
        }


        $doc_type_name = provider_document_type::where('id', $request->doc_type_id)->first();


        $new_doc->admin_id = Auth::user()->id;
        $new_doc->provider_id = $request->provider_id;
        $new_doc->doc_type_id = isset($doc_type_name) ? $doc_type_name->id : null;
        $new_doc->doc_type = isset($doc_type_name) ? $doc_type_name->doc_type_name : null;
        $new_doc->description = $request->description;
        if ($request->exp_date != null || $request->exp_date != "") {
            $new_doc->exp_date = Carbon::parse($request->exp_date)->format('Y-m-d');
        } else {
            $new_doc->exp_date = null;
        }
        $new_doc->created_by = Auth::user()->name;
        $new_doc->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $new_doc->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Document Added";
        $new_act->save();

        return back()->with('success', 'Provider Document Successfully Added');
    }


    public function provider_document_update(Request $request)
    {
        $doc_type_name = provider_document_type::where('id', $request->doc_type_id)->first();

        $update_doc = provider_document::where('id', $request->doc_edit_id)->first();
        if ($request->hasFile('doc_file')) {
//            unlink($update_doc->file);
            $image = $request->file('doc_file');
            $name = $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/documents/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $update_doc->file = $imageUrl;
        }
        $update_doc->doc_type_id = isset($doc_type_name) ? $doc_type_name->id : null;
        $update_doc->doc_type = isset($doc_type_name) ? $doc_type_name->doc_type_name : null;
        $update_doc->description = $request->description;
        if ($request->exp_date != null || $request->exp_date != "") {
            $update_doc->exp_date = Carbon::parse($request->exp_date)->format('Y-m-d');
        } else {
            $update_doc->exp_date = $update_doc->exp_date;
        }
        $update_doc->created_by = Auth::user()->name;
        $update_doc->save();


        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $update_doc->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Document Updated";
        $new_act->save();

        return back()->with('success', 'Provider Document Successfully Updated');
    }


    public function provider_document_delete($id)
    {
        $delete_doc = provider_document::where('id', $id)->first();
        if ($delete_doc) {
//            unlink($delete_doc->file);

            $new_act = new provider_activity();
            $new_act->admin_id = Auth::user()->id;
            $new_act->provider_id = $delete_doc->provider_id;
            $new_act->created_by = Auth::user()->name;
            $new_act->message = "Provider Document Deleted";
            $new_act->save();

            $delete_doc->delete();
            return back()->with('success', 'Provider Document Successfully Deleted');
        } else {
            return back()->with('alert', 'Provider Document Not Found');
        }
    }

    public function provider_document_type_get_all(Request $request)
    {
        $all_doc_type = provider_document_type::all();
        return response()->json($all_doc_type, 200);
    }


    public function provider_insurance_document($id)
    {
        $provider = Provider::where('id', $id)->first();
        $contract_name = contact_name::orderBy('contact_name', 'asc')->get();
        $document_types = provider_document_type::orderBy('doc_type_name', 'asc')->get();
        $all_ins_dcouments = provider_insurance_document::where('provider_id', $id)->orderBy('id', 'desc')->paginate(10);
        return view('accountManager.provider.providerInsuranceDocument', compact('provider', 'contract_name', 'document_types', 'all_ins_dcouments'));
    }


    public function provider_insurance_document_save(Request $request)
    {
       
        $new_pro_ins_doc = new provider_insurance_document();
        $new_pro_ins_doc->provider_id = $request->provider_id;
        $new_pro_ins_doc->contract_name_id = $request->contract_name_id;
        $new_pro_ins_doc->document_type_id = $request->document_type_id;
        $new_pro_ins_doc->description = $request->description;
        $new_pro_ins_doc->created_on = Carbon::now()->format('Y-m-d');
        $new_pro_ins_doc->created_by = Auth::user()->name;
        $new_pro_ins_doc->user_id = Auth::user()->id;
        $new_pro_ins_doc->user_type = 1;

        if ($request->hasFile('prov_ins_file')) {
            $image = $request->file('prov_ins_file');
            $name = $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/provider_insurance/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_pro_ins_doc->prov_ins_file = $imageUrl;
        }
        $new_pro_ins_doc->save();
        return back()->with('success', 'Provider Insurance Document Successfully Created');
    }


    public function provider_insurance_document_update(Request $request)
    {
        $new_pro_ins_doc = provider_insurance_document::where('id', $request->edit_ins_doc)->first();
        $new_pro_ins_doc->contract_name_id = $request->contract_name_id;
        $new_pro_ins_doc->document_type_id = $request->document_type_id;
        $new_pro_ins_doc->description = $request->description;
        $update_doc = provider_document::where('id', $request->doc_edit_id)->first();
       
        if ($request->hasFile('prov_ins_file')) {
            $image = $request->file('prov_ins_file');
            $name = $image->getClientOriginalName();
            $uploadPath = 'assets/dashboard/provider_insurance/';
            $image->move($uploadPath, $name);
            $imageUrl = $uploadPath . $name;

            $new_pro_ins_doc->prov_ins_file = $imageUrl;
        }
        $new_pro_ins_doc->save();
        return back()->with('success', 'Provider Insurance Document Successfully Updated');
    }


    public function provider_insurance_document_delete($id)
    {
        $pro_ins_doc_del = provider_insurance_document::where('id', $id)->first();
        if ($pro_ins_doc_del) {
            $pro_ins_doc_del->delete();
            return back()->with('success', 'Provider Insurance Document Successfully Deleted');
        } else {
            return back()->with('alert', 'Provider Insurance Document Not Found');
        }
    }


    public function provider_portal($id)
    {
        $provider = Provider::where('id', $id)->first();
        $check_provider_portal = provider_portal::where('provider_id', $id)->first();
        $provider_all_email = provider_email::where('provider_id', $id)->get();
        if ($check_provider_portal) {
            $portal = $check_provider_portal;
        } else {
            $portal = new provider_portal();
            $portal->provider_id = $id;
            $portal->save();
        }
        return view('accountManager.provider.providerPortal', compact('provider', 'portal', 'provider_all_email'));
    }


    public function provider_portal_save(Request $request)
    {
        $portal = provider_portal::where('id', $request->portal_edit_id)->first();
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

        return back()->with('success', 'Provider Portal Successfully Updated');
    }


    public function provider_portal_send_access(Request $request)
    {
        $email = $request->access_email;
        $provider_id = $request->portal_acess_id;

        $provider = Provider::where('id', $provider_id)->where('email', $email)->first();
        $provider_emails = provider_email::where('provider_id', $provider_id)->where('email', $email)->first();
        if ($provider) {

            $new_access = new portal_access_email();
            $new_access->admin_id = Auth::user()->id;
            $new_access->provider_id = $provider_id;
            $new_access->email = $email;
            $new_access->verify_id = rand(00000, 99999) . $provider_id . rand(00, 99) . rand(00000, 999999);
            $new_access->is_use = 0;
            $new_access->save();


            $to = $email;
            $url = route('access.email', $new_access->verify_id);
            $msg = [
                'name' => $provider->full_name,
                'url' => $url
            ];
            Mail::to($to)->send(new AccessEmail($msg));
            return back()->with('success', 'Portal Link Has Been Send');

        } elseif ($provider_emails) {
            $new_access = new portal_access_email();
            $new_access->admin_id = Auth::user()->id;
            $new_access->provider_id = $provider_id;
            $new_access->email = $email;
            $new_access->verify_id = rand(00000, 99999) . $provider_id . rand(00, 99) . rand(00000, 999999);
            $new_access->is_use = 0;
            $new_access->save();

            return back()->with('success', 'Portal Link Has Been Send');

        } else {
            return back()->with('alert', 'Something Went Wrong');
        }
    }


    public function provider_online_access($id)
    {
        $provider = Provider::where('id', $id)->first();
        $provider_online_access = provider_online_access::where('provider_id', $id)->paginate(20);
        return view('accountManager.provider.providerOnlineAccess', compact('provider', 'provider_online_access'));
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

        return back()->with('success', 'Provider Online Access Successfully Created');
    }


    public function provider_online_access_update(Request $request)
    {
        $update_access = provider_online_access::where('id', $request->access_edit_id)->first();
        $update_access->name = $request->name;
        $update_access->url = $request->url;
        $update_access->user_name = $request->user_name;
        if ($request->password != null || $request->password != '') {
            $update_access->password = $request->password;
        }
        $update_access->save();

        $new_act = new provider_activity();
        $new_act->admin_id = Auth::user()->id;
        $new_act->provider_id = $update_access->provider_id;
        $new_act->created_by = Auth::user()->name;
        $new_act->message = "Provider Online Access Update";
        $new_act->save();

        return back()->with('success', 'Provider Online Access Successfully Updated');
    }


    public function provider_online_access_delete($id)
    {
        $online_access_delete = provider_online_access::where('id', $id)->first();

        if ($online_access_delete) {
            $online_access_delete->delete();
            return back()->with('success', 'Provider Online Access Successfully Delete');
        } else {
            return back()->with('alert', 'Provider Online Access Not Found');
        }
    }


    public function provider_activity($id)
    {
        $provider = Provider::where('id', $id)->first();
        $activity = provider_activity::where('provider_id', $id)->paginate(20);
        return view('accountManager.provider.providerActivity', compact('provider', 'activity'));
    }


    public function arrayPaginator($array, $request)
    {
        $page = $request->input('page', 1);
        $perPage = 20;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);

    }


}
