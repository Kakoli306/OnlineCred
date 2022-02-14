<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\assign_practice_user;
use App\Models\BaseStaff;
use App\Models\assign_practice;
use App\Models\contract_status;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\report;
use App\Models\report_contract;
use App\Models\report_provider;
use App\Models\report_status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\LengthAwarePaginator;


class AdminReportController extends Controller
{
    public function report()
    {
        $all_status = contract_status::all();
        $all_reports = report::orderBy('id', 'desc')->paginate(15);
        //dd($all_reports);
        return view('admin.report.report', compact('all_reports', 'all_status'));
    }

    public function report_get_all_facility(Request $request)
    {
        $all_fac = practice::select('id', 'business_name')->get();
        return response()->json($all_fac, 200);
    }

    public function report_get_provider_by_facility(Request $request)
    {
        $provider = assign_practice::where('practice_id', $request->fac_id)->get();
        $array = [];
        foreach ($provider as $prov) {
            array_push($array, $prov->provider_id);
        }


        $prov_name = Provider::select('id', 'full_name', 'practice_id')->where('practice_id', $request->fac_id)->get();
        return response()->json($prov_name, 200);
    }


    public function report_get_contact_by_provider(Request $request)
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

// //dd($last_report);
//         $new_report = new report();
//         $new_report->user_id = Auth::user()->id;
//         $new_report->user_type = Auth::user()->account_type;
//         $new_report->report_name = "REPORT - " . $last_report_id;
//         $new_report->facility_id = $request->facility_id;
//       //  $new_report->provider_id = $request->provider_id;
//       //  $new_report->contact_id = $request->contact_id;
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

if ($providers) {
    if (count($providers) > 0) {
        for ($i = 0; $i < count($providers); $i++) {
            $new_reminder_provider = new report_provider();
            $new_reminder_provider->report_id = $new_report->id;
            $new_reminder_provider->provider_id = $providers[$i];
            $new_reminder_provider->save();
        }
    }
}


$contracts = $request->all_con_data;

if ($contracts) {
    if (count($contracts) > 0) {
        for ($i = 0; $i < count($contracts); $i++) {
            $new_reminder_contract = new report_contract();
            $new_reminder_contract->report_id = $new_report->id;
            $new_reminder_contract->contract_id = $contracts[$i];
            $new_reminder_contract->save();
        }
    }
}


$status = $request->all_status_data;
if ($status) {
    if (count($status) > 0) {
        for ($i = 0; $i < count($status); $i++) {
            $new_reminder_status = new report_status();
            $new_reminder_status->report_id = $new_report->id;
            $new_reminder_status->status_id = $status[$i];
            $new_reminder_status->save();
        }
    }
}


return back()->with('success', 'Report Submitted');

    }

    public function report_export($id)
    {
        $report = report::where('id', $id)->first();
        return Response::download(public_path("report/" . $report->report_name . ".csv"));
    }

    public function report_show_all_record(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');

        $all_prc_data = $request->all_prc_data;
        $all_prov_name = $request->all_prov_name;
        $all_con_data = $request->all_con_data;
        $fowllowup_filter = $request->fowllowup_filter;
        $status_filter = $request->status_filter;
        $user_type = $request->user_type;
        $user_id = $request->user_id;

        $assign_prc = assign_practice_user::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->get();


        $array = [];
        foreach ($assign_prc as $acprc) {
            array_push($array, $acprc->practice_id);
        }


        $query = "SELECT * FROM reminders WHERE is_show=1 ";

        if (isset($all_prc_data) && $all_prc_data != null || $all_prc_data != '') {
            $query .= "AND facility_id=$all_prc_data ";
        }


        if ($all_prc_data == null || $all_prc_data == '') {
            $CAT_filter = implode("','", $array);
            $query .= "AND facility_id IN('" . $CAT_filter . "') ";
        }

        if (isset($all_prov_name)) {

            $prov_array = [];
            foreach ($all_prov_name as $all_provname) {
                array_push($prov_array, $all_provname);
            }

            $PROV_filter = implode("','", $prov_array);
            $query .= "AND provider_id IN('" . $PROV_filter . "') ";
        }

        if (isset($all_con_data)) {

            $con_array = [];
            foreach ($all_con_data as $all_condata) {
                array_push($con_array, $all_condata);
            }

            $CON_filter = implode("','", $con_array);
            $query .= "AND contract_id IN('" . $CON_filter . "') ";
        }

        if (isset($fowllowup_filter)) {
            $query .= "AND followup_date<='$fowllowup_filter' ";
        }

        if (isset($status_filter)) {
            $status_array = [];
            foreach ($status_filter as $statusdata) {
                array_push($status_array, $statusdata);
            }
            $STATUS_filter_DATA = implode("','", $status_array);
            $query .= "AND status IN('" . $STATUS_filter_DATA . "') ";
        }

        if (isset($user_type) && isset($user_id)){
            if($user_type != null && $user_id != null){
                $query .= "AND assignedto_user_type = $user_type ";
                $query .= "AND assignedto_user_id = $user_id ";
            }
        }

        $query .= "ORDER BY id DESC";
        $query_exe = DB::select($query);


        $reminders = $this->arrayPaginator($query_exe, $request);


        return response()->json([
            'notices' => $reminders,
            'view' => View::make('admin.report.include.reportTable', compact('reminders'))->render(),
            'pagination' => (string)$reminders->links()
        ]);
    }


    public function report_show_all_record_get(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');


        $all_prc_data = $request->all_prc_data;
        $all_prov_name = $request->all_prov_name;
        $all_con_data = $request->all_con_data;
        $fowllowup_filter = $request->fowllowup_filter;
        $status_filter = $request->status_filter;
        $user_type = $request->user_type;
        $user_id = $request->user_id;


        $assign_prc = assign_practice_user::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->get();


        $array = [];
        foreach ($assign_prc as $acprc) {
            array_push($array, $acprc->practice_id);
        }


        $query = "SELECT * FROM reminders WHERE is_show=1 ";

        if (isset($all_prc_data) && $all_prc_data != null || $all_prc_data != '') {
            $query .= "AND facility_id=$all_prc_data ";
        }



        if ($all_prc_data == null || $all_prc_data == '') {
            $CAT_filter = implode("','", $array);
            $query .= "AND facility_id IN('" . $CAT_filter . "') ";
        }

        if (isset($all_prov_name)) {

            $prov_array = [];
            foreach ($all_prov_name as $all_provname) {
                array_push($prov_array, $all_provname);
            }

            $PROV_filter = implode("','", $prov_array);
            $query .= "AND provider_id IN('" . $PROV_filter . "') ";
        }

        if (isset($all_con_data)) {

            $con_array = [];
            foreach ($all_con_data as $all_condata) {
                array_push($con_array, $all_condata);
            }

            $CON_filter = implode("','", $con_array);
            $query .= "AND contract_id IN('" . $CON_filter . "') ";
        }

        if (isset($fowllowup_filter)) {
            $query .= "AND followup_date<='$fowllowup_filter' ";
        }

        if (isset($status_filter)) {
            $status_array = [];
            foreach ($status_filter as $statusdata) {
                array_push($status_array, $statusdata);
            }
            $STATUS_filter_DATA = implode("','", $status_array);
            $query .= "AND status IN('" . $STATUS_filter_DATA . "') ";
        }

        if (isset($user_type) && isset($user_id)){
            if($user_type != null && $user_id != null){
                $query .= "AND assignedto_user_type = $user_type ";
                $query .= "AND assignedto_user_id = $user_id ";
            }
        }

        $query .= "ORDER BY id DESC";
        $query_exe = DB::select($query);


        $reminders = $this->arrayPaginator($query_exe, $request);


        return response()->json([
            'notices' => $reminders,
            'view' => View::make('admin.report.include.reportTable', compact('reminders'))->render(),
            'pagination' => (string)$reminders->links()
        ]);
    }

    public function arrayPaginator($array, $request)
    {
        $page = $request->input('page', 1);
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);

    }
    

}
