<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\assign_practice;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminReportController extends Controller
{
    public function report()
    {
        $all_reports = report::where('admin_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('admin.report.report', compact('all_reports'));
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


        $prov_name = Provider::select('id', 'full_name')->whereIn('id', $array)->get();
        return response()->json($prov_name, 200);
    }


    public function report_get_contact_by_provider(Request $request)
    {
        $contacts = provider_contract::where('provider_id', $request->prov_id)->get();
        return response()->json($contacts, 200);
    }


    public function report_save(Request $request)
    {
        $last_report = report::where('admin_id', Auth::user()->id)->first();
        if ($last_report) {
            $last_report_id = $last_report->id;
        } else {
            $last_report_id = 0;
        }

        $new_report = new report();
        $new_report->admin_id = Auth::user()->id;
        $new_report->report_name = "REPORT - " . $last_report_id;
        $new_report->facility_id = $request->facility_id;
        $new_report->provider_id = $request->provider_id;
        $new_report->contact_id = $request->contact_id;
        $new_report->status = $request->status;
        $new_report->form_date = Carbon::parse($request->form_date)->format('Y-m-d');
        $new_report->to_date = Carbon::parse($request->to_date)->format('Y-m-d');
        $new_report->is_completed = 1;
        $new_report->report_time = Carbon::now()->format('Y-m-d H:m:s');
        $new_report->save();
        return back()->with('success', 'Report Submitted');
    }

    public function report_export($id)
    {
        $report = report::where('id', $id)->first();
        return Response::download(public_path("report/" . $report->report_name . ".csv"));
    }

}
