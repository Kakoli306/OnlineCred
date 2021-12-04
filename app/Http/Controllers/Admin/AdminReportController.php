<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\assign_practice;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function report()
    {
        return view('admin.report.report');
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
}
