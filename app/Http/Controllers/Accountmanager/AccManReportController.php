<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use App\Models\assign_practice_user;
use App\Models\contract_status;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\reminder;
use App\Models\report;
use App\Models\report_contract;
use App\Models\report_provider;
use App\Models\report_status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\AccountManager;


class AccManReportController extends Controller
{
    public function report()
    {
        $all_status = contract_status::all();
        $all_reports = report::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->orderBy('id', 'desc')->paginate(10);
        return view('accountManager.report.report', compact('all_reports', 'all_status'));
    }


    public function report_get_all_facility(Request $request)
    {
        $ass_prc = assign_practice_user::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)->get();


        $array = [];
        foreach ($ass_prc as $asspc) {
            array_push($array, $asspc->practice_id);
        }
<<<<<<< HEAD
        $all_fac = practice::select('id', 'business_name')->whereIn('id', $array)->orderBy('business_name','asc')->get();
=======
        $all_fac = practice::select('id', 'business_name')->whereIn('id', $array)->orderBy('business_name','asc')
        ->get();
        return response()->json($all_prc, 200);
>>>>>>> 66cee114dba548922cc5070c3a4dd4cbb5049534
        return response()->json($all_fac, 200);
    }

    public function report_provider_by_facility(Request $request)
    {
        $provider = assign_practice_user::where('user_id', Auth::user()->id)->where('user_type', Auth::user()->account_type)->where('practice_id', $request->fac_id)->get();
        $array = [];
        foreach ($provider as $prov) {
            array_push($array, $prov->provider_id);
        }


        $prov_name = Provider::select('id', 'full_name', 'practice_id')->where('practice_id', $request->fac_id)->get();
        return response()->json($prov_name, 200);
    }


    public function report_contract_by_provider(Request $request)
    {
        $contacts = provider_contract::where('provider_id', $request->prov_id)->get();
        return response()->json($contacts, 200);
    }

    public function report_save(Request $request)
    {
//         $last_report = report::where('user_id', Auth::user()->id)
//             ->where('user_type', Auth::user()->account_type)
//             ->first();
//         if ($last_report) {
//             $last_report_id = $last_report->id;
//         } else {
//             $last_report_id = 0;
//         }


//         $new_report = new report();
//         $new_report->user_id = Auth::user()->id;
//         $new_report->user_type = Auth::user()->account_type;
//         $new_report->report_name = 'Report-' .  $last_report_id . Auth::user()->id . Auth::user()->account_type;
//         $new_report->facility_id = $request->facility_id;
//         $new_report->provider_id = $request->provider_id;
//         $new_report->contact_id = $request->contact_id;
// //        $new_report->status = $request->status;
//         $new_report->form_date = Carbon::parse($request->form_date)->format('Y-m-d');
//         $new_report->to_date = Carbon::parse($request->to_date)->format('Y-m-d');
//         $new_report->is_completed = 1;
//         $new_report->report_time = Carbon::now()->format('Y-m-d H:m:s');
//         $new_report->save();


//         $data = $request->report_status;

//         if (count($data) > 0) {
//             for ($i = 0; $i < count($data); $i++) {
//                 $new_report_status = new report_status();
//                 $new_report_status->report_id = $new_report->id;
//                 $new_report_status->status_id = $data[$i];
//                 $new_report_status->save();
//             }
//         }


//         return back()->with('success', 'Report Submitted');

$last_report_id = report::orderBy('id', 'desc')->first();
if ($last_report_id) {
    $report_id = Auth::user()->id . Auth::user()->account_type . $last_report_id->id;
} else {
    $report_id = Auth::user()->id . Auth::user()->account_type . '0';
}
$new_report = new report();
$new_report->user_id = Auth::user()->id;
$new_report->user_type = Auth::user()->account_type;
$new_report->report_type = 2;
$new_report->report_name = 'Report-' . $report_id;
$new_report->facility_id = $request->all_prc_data;
$new_report->is_completed = 1;
$new_report->save();


$providers = $request->all_prov_name;

if (count($providers) > 0) {
    for ($i = 0; $i < count($providers); $i++) {
        $new_reminder_provider = new report_provider();
        $new_reminder_provider->report_id = $new_report->id;
        $new_reminder_provider->provider_id = $providers[$i];
        $new_reminder_provider->save();
    }
}


$contracts = $request->all_con_data;

if (count($contracts) > 0) {
    for ($i = 0; $i < count($contracts); $i++) {
        $new_reminder_contract = new report_contract();
        $new_reminder_contract->report_id = $new_report->id;
        $new_reminder_contract->contract_id = $contracts[$i];
        $new_reminder_contract->save();
    }
}


$status = $request->all_status_data;

if (count($status) > 0) {
    for ($i = 0; $i < count($status); $i++) {
        $new_reminder_status = new report_status();
        $new_reminder_status->report_id = $new_report->id;
        $new_reminder_status->status_id = $status[$i];
        $new_reminder_status->save();
    }
}


return back()->with('success', 'Reminder Submitted');



    }

}
