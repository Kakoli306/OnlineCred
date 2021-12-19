<?php

namespace App\Http\Controllers\BaseStaff;

use App\Http\Controllers\Controller;
use App\Models\assign_practice_user;
use App\Models\contract_status;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\report;
use App\Models\report_status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseStaffReportController extends Controller
{
    public function report()
    {
        $all_status = contract_status::all();
        $all_reports = report::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->orderBy('id', 'desc')->paginate(10);
        return view('baseStaff.report.report', compact('all_reports', 'all_status'));
    }


    public function report_get_all_facility(Request $request)
    {
        $all_fac = practice::select('id', 'business_name')->get();
        return response()->json($all_fac, 200);
    }

    public function report_provider_by_facility(Request $request)
    {
        $provider = assign_practice_user::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->where('practice_id', $request->fac_id)
            ->get();
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
        $last_report = report::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->first();
        if ($last_report) {
            $last_report_id = $last_report->id;
        } else {
            $last_report_id = 0;
        }


        $new_report = new report();
        $new_report->user_id = Auth::user()->id;
        $new_report->user_type = Auth::user()->account_type;
        $new_report->report_name = "REPORT - " . $last_report_id . Auth::user()->id . Auth::user()->account_type;
        $new_report->facility_id = $request->facility_id;
        $new_report->provider_id = $request->provider_id;
        $new_report->contact_id = $request->contact_id;
//        $new_report->status = $request->status;
        $new_report->form_date = Carbon::parse($request->form_date)->format('Y-m-d');
        $new_report->to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        $new_report->is_completed = 1;
        $new_report->report_time = Carbon::now()->format('Y-m-d H:m:s');
        $new_report->save();


        $data = $request->report_status;

        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $new_report_status = new report_status();
                $new_report_status->report_id = $new_report->id;
                $new_report_status->status_id = $data[$i];
                $new_report_status->save();
            }
        }


        return back()->with('success', 'Report Submitted');
    }


}
