<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\contract_status;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AdminReminderController extends Controller
{
    public function reminder()
    {
        $status = contract_status::all();
        return view('admin.reminder.reminderList', compact('status'));
    }

    public function reminder_get_all_prc(Request $request)
    {
        $all_prc = practice::all();
        return response()->json($all_prc, 200);
    }

    public function reminder_al_prov_by_prc(Request $request)
    {

        $reminder_prcs = reminder::where('facility_id', $request->prc_id)->get();
        $array = [];
        foreach ($reminder_prcs as $prc) {
            array_push($array, $prc->provider_id);
        }

        $provs = Provider::whereIn('id', $array)->get();
        return response()->json($provs, 200);


    }


    public function reminder_con_by_prov(Request $request)
    {
        $con = provider_contract::where('provider_id', $request->prov_id)->get();
        return response()->json($con, 200);
    }


    public function reminder_show_all_record(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');

        $all_prc_data = $request->all_prc_data;
        $all_prov_name = $request->all_prov_name;
        $all_con_data = $request->all_con_data;
        $fowllowup_filter = $request->fowllowup_filter;
        $status_filter = $request->status_filter;


        $query = "SELECT * FROM reminders WHERE is_show=1 ";

        if (isset($all_prc_data)) {
            $query .= "AND facility_id=$all_prc_data ";
        }

        if (isset($all_prov_name)) {
            $query .= "AND provider_id=$all_prov_name ";
        }

        if (isset($all_con_data)) {
            $query .= "AND contract_id=$all_con_data ";
        }

        if (isset($fowllowup_filter)) {
            $query .= "AND followup_date='$fowllowup_filter' ";
        }

        if (isset($status_filter)) {
            $query .= "AND status='$status_filter' ";
        }

        $query .= "ORDER BY id DESC";
        $query_exe = DB::select($query);


        $reminders = $this->arrayPaginator($query_exe, $request);


        return response()->json([
            'notices' => $reminders,
            'view' => View::make('admin.reminder.include.reminderTable', compact('reminders'))->render(),
            'pagination' => (string)$reminders->links()
        ]);
    }


    public function reminder_show_all_record_get(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $all_prc_data = $request->all_prc_data;
        $all_prov_name = $request->all_prov_name;
        $all_con_data = $request->all_con_data;
        $fowllowup_filter = $request->fowllowup_filter;
        $status_filter = $request->status_filter;


        $query = "SELECT * FROM reminders WHERE is_show=1 ";

        if (isset($all_prc_data)) {
            $query .= "AND facility_id=$all_prc_data ";
        }

        if (isset($all_prov_name)) {
            $query .= "AND provider_id=$all_prov_name ";
        }

        if (isset($all_con_data)) {
            $query .= "AND contract_id=$all_con_data ";
        }

        if (isset($fowllowup_filter)) {
            $query .= "AND followup_date='$fowllowup_filter' ";
        }

        if (isset($status_filter)) {
            $query .= "AND status='$status_filter' ";
        }

        $query .= "ORDER BY id DESC";
        $query_exe = DB::select($query);


        $reminders = $this->arrayPaginator($query_exe, $request);


        return response()->json([
            'notices' => $reminders,
            'view' => View::make('admin.reminder.include.reminderTable', compact('reminders'))->render(),
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
