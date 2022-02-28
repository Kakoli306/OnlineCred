<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\assign_practice_user;
use App\Models\BaseStaff;
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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class AdminReminderController extends Controller
{
    public function reminder()
    {
      return view('admin.reminder.reminderList');
    }

    public function reminder_get_all_prc(Request $request)
    {
        $all_prc = practice::all();
        $assign_prc = assign_practice_user::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->get();
        $array = [];
        foreach ($assign_prc as $acprc) {
            array_push($array, $acprc->practice_id);
        }

        $all_prc = practice::whereIn('id',$array)->orderBy('business_name','asc')->get();

        return response()->json($all_prc, 200);
    }

    public function reminder_get_all_users(Request $request)
    {
        $reminder_users = reminder::where('user_id', $request->user_id)->get();

        return response()->json($reminder_users, 200);

    }

    public function reminder_al_prov_by_prc(Request $request)
    {

        $reminder_prcs = reminder::where('facility_id', $request->prc_id)->get();
        $array = [];
        foreach ($reminder_prcs as $prc) {
            array_push($array, $prc->provider_id);
        }

        $provs = Provider::whereIn('id', $array)->where('is_active', 1)->get();
        return response()->json($provs, 200);
    }


    public function reminder_con_by_prov(Request $request)
    {
        $con = provider_contract::where('provider_id', $request->prov_id)->get();
        return response()->json($con, 200);
    }



    public function reminder_get_all_status(Request $request)
    {
        $all_status = contract_status::all();
        return response()->json($all_status, 200);
    }


    public function reminder_show_all_record(Request $request)
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
            if($user_type != 0 && $user_id != 0){
                $query .= "AND assignedto_user_type = $user_type ";
                $query .= "AND assignedto_user_id = $user_id ";
            }
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
            if($user_type != 0 && $user_id != 0){
                $query .= "AND assignedto_user_type = $user_type ";
                $query .= "AND assignedto_user_id = $user_id ";
            }
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


    public function reminder_all_data_get(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');

        $assign_prc = assign_practice_user::where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->get();


        $array = [];
        foreach ($assign_prc as $acprc) {
            array_push($array, $acprc->practice_id);
        }

        $all_reminder = reminder::where(function ($query) use ($array) {
            if (count($array) > 0) {
                $query->whereIn('facility_id', $array);
            }
        })->orderBy('id', 'desc')->get();
        return DataTables::of($all_reminder)
            ->addColumn('action', function ($all_reminder) {
                $fac_name = Provider::select('id', 'full_name')->where('id', $all_reminder->provider_id)->first();
                if ($fac_name) {
                    return '<a href="' . route('admin.provider.contract', $all_reminder->provider_id) . '"></a>';
                } else {
                    return "";
                }
            })
            ->editColumn('facility_id', function ($all_reminder) {
                $fac_name = practice::select('id', 'business_name')->where('id', $all_reminder->facility_id)->first();
                if ($fac_name) {
                    return $fac_name->business_name;
                } else {
                    return "";
                }
            })
            ->editColumn('provider_id', function ($all_reminder) {
                $fac_name = Provider::select('id', 'full_name')->where('id', $all_reminder->provider_id)->first();
                if ($fac_name) {
                    return '<a target="_blank" href="' . route('admin.provider.contract', $all_reminder->provider_id) . '">' . $fac_name->full_name . '</a>';
                } else {
                    return "";
                }
            })
            ->editColumn('contract_id', function ($all_reminder) {
                $fac_name = provider_contract::select('id', 'contract_name')->where('id', $all_reminder->contract_id)->first();
                if ($fac_name) {
                    return $fac_name->contract_name;
                } else {
                    return "";
                }
            })
            ->editColumn('followup_date', function ($all_reminder) {
                if ($all_reminder->followup_date != null || $all_reminder->followup_date != '') {
                    return Carbon::parse($all_reminder->followup_date)->format('m/d/Y');
                } else {
                    return "";
                }
            })
            ->editColumn('status', function ($all_reminder) {
                $status_name = contract_status::where('id', $all_reminder->status)->first();
                if ($status_name) {
                    return $status_name->contact_status;
                } else {
                    return "";
                }
            })
            ->editColumn('assign_to', function ($all_reminder) {
                $create_by_admin = Admin::select('id', 'name')->where('id', $all_reminder->user_id)->where('account_type', $all_reminder->user_type)->first();
                $create_by_manager = AccountManager::select('id', 'name')->where('id', $all_reminder->user_id)->where('account_type', $all_reminder->user_type)->first();
                $create_by_staff = BaseStaff::select('id', 'name')->where('id', $all_reminder->user_id)->where('account_type', $all_reminder->user_type)->first();


                if ($create_by_admin) {
                    $created_by = 'CreatedBy- ' . $create_by_admin->name;
                } elseif ($create_by_manager) {
                    $created_by = 'CreatedBy- ' . $create_by_manager->name;
                } elseif ($create_by_staff) {
                    $created_by = 'CreatedBy- ' . $create_by_staff->name;
                } else {
                    $created_by = '';
                }

                if ($all_reminder->is_assign == 1) {
                    if ($all_reminder->assignedto_user_type == 1) {
                        $assignto_admin = Admin::select('id', 'name')->where('id', $all_reminder->assignedto_user_id)->first();
                        if ($assignto_admin) {
                            $assign_to = ' / AssignedTo -' . $assignto_admin->name;
                        } else {
                            $assign_to = '';
                        }

                    } elseif ($all_reminder->assignedto_user_type == 2) {
                        $assignto_manager = AccountManager::select('id', 'name')->where('id', $all_reminder->assignedto_user_id)->first();
                        if ($assignto_manager) {
                            $assign_to = ' / AssignedTo -' . $assignto_manager->name;
                        } else {
                            $assign_to = '';
                        }

                    } elseif ($all_reminder->assignedto_user_type == 3) {
                        $assignto_staff = BaseStaff::select('id', 'name')->where('id', $all_reminder->assignedto_user_id)->first();
                        if ($assignto_staff) {
                            $assign_to = ' / AssignedTo -' . $assignto_staff->name;
                        } else {
                            $assign_to = '';
                        }

                    } else {
                        $assign_to = '';
                    }
                } else {
                    $assign_to = '';
                }


                return $created_by . $assign_to;


            })

            ->rawColumns(['facility_id', 'provider_id', 'contract_id', 'followup_date', 'status'])
            ->make(true);
    }


    public function reminder_all_data_get_filter(Request $request)
    {

        $today_date = Carbon::now()->format('Y-m-d');

        $all_prc_data = $request->all_prc_data;
        $all_prov_name = $request->all_prov_name;
        $all_con_data = $request->all_con_data;
        $fowllowup_filter = $request->fowllowup_filter;
        $status_filter = $request->status_filter;


        $all_reminder = reminder::where(function ($query) use ($all_prc_data) {
            if ($all_prc_data) {
                $query->where('facility_id', $all_prc_data);
            }
        })->where(function ($query) use ($all_prov_name) {
            if ($all_prov_name) {
                $query->whereIn('provider_id', $all_prov_name);
            }
        })->where(function ($query) use ($all_con_data) {
            if ($all_con_data) {
                $query->whereIn('contract_id', $all_con_data);
            }
        })->where(function ($query) use ($fowllowup_filter) {
            if ($fowllowup_filter) {
                $query->whereIn('followup_date', '<=', $fowllowup_filter);
            }
        })->where(function ($query) use ($status_filter) {
            if ($status_filter) {
                $query->where('status', $status_filter);
            }
        })->orderBy('id', 'desc')->get();
        return DataTables::of($all_reminder)
            ->addColumn('action', function ($all_reminder) {
                $fac_name = Provider::select('id', 'full_name')->where('id', $all_reminder->provider_id)->first();
                if ($fac_name) {
                    return '<a href="' . route('admin.provider.contract', $all_reminder->provider_id) . '"></a>';
                } else {
                    return "";
                }
            })
            ->editColumn('facility_id', function ($all_reminder) {
                $fac_name = practice::select('id', 'business_name')->where('id', $all_reminder->facility_id)->first();
                if ($fac_name) {
                    return $fac_name->business_name;
                } else {
                    return "";
                }
            })
            ->editColumn('provider_id', function ($all_reminder) {
                $fac_name = Provider::select('id', 'full_name')->where('id', $all_reminder->provider_id)->first();
                if ($fac_name) {
                    return '<a target="_blank" href="' . route('admin.provider.contract', $all_reminder->provider_id) . '">' . $fac_name->full_name . '</a>';
                } else {
                    return "";
                }
            })
            ->editColumn('contract_id', function ($all_reminder) {
                $fac_name = provider_contract::select('id', 'contract_name')->where('id', $all_reminder->contract_id)->first();
                if ($fac_name) {
                    return $fac_name->contract_name;
                } else {
                    return "";
                }
            })
            ->editColumn('followup_date', function ($all_reminder) {
                if ($all_reminder->followup_date != null || $all_reminder->followup_date != '') {
                    return Carbon::parse($all_reminder->followup_date)->format('m/d/Y');
                } else {
                    return "";
                }
            })
            ->editColumn('status', function ($all_reminder) {
                $status_name = contract_status::where('id', $all_reminder->status)->first();
                if ($status_name) {
                    return $status_name->contact_status;
                } else {
                    return "";
                }
            })
            ->editColumn('assign_to', function ($all_reminder) {
                $create_by_admin = Admin::select('id', 'name')->where('id', $all_reminder->user_id)->where('account_type', $all_reminder->user_type)->first();
                $create_by_manager = AccountManager::select('id', 'name')->where('id', $all_reminder->user_id)->where('account_type', $all_reminder->user_type)->first();
                $create_by_staff = BaseStaff::select('id', 'name')->where('id', $all_reminder->user_id)->where('account_type', $all_reminder->user_type)->first();


                if ($create_by_admin) {
                    $created_by = 'CreatedBy- ' . $create_by_admin->name;
                } elseif ($create_by_manager) {
                    $created_by = 'CreatedBy- ' . $create_by_manager->name;
                } elseif ($create_by_staff) {
                    $created_by = 'CreatedBy- ' . $create_by_staff->name;
                } else {
                    $created_by = '';
                }

                if ($all_reminder->is_assign == 1) {
                    if ($all_reminder->assignedto_user_type == 1) {
                        $assignto_admin = Admin::select('id', 'name')->where('id', $all_reminder->assignedto_user_id)->first();
                        if ($assignto_admin) {
                            $assign_to = ' / AssignedTo -' . $assignto_admin->name;
                        } else {
                            $assign_to = '';
                        }

                    } elseif ($all_reminder->assignedto_user_type == 2) {
                        $assignto_manager = AccountManager::select('id', 'name')->where('id', $all_reminder->assignedto_user_id)->first();
                        if ($assignto_manager) {
                            $assign_to = ' / AssignedTo -' . $assignto_manager->name;
                        } else {
                            $assign_to = '';
                        }

                    } elseif ($all_reminder->assignedto_user_type == 3) {
                        $assignto_staff = BaseStaff::select('id', 'name')->where('id', $all_reminder->assignedto_user_id)->first();
                        if ($assignto_staff) {
                            $assign_to = ' / AssignedTo -' . $assignto_staff->name;
                        } else {
                            $assign_to = '';
                        }

                    } else {
                        $assign_to = '';
                    }
                } else {
                    $assign_to = '';
                }


                return $created_by . $assign_to;


            })
            ->rawColumns(['facility_id', 'provider_id', 'contract_id', 'followup_date', 'status'])
            ->make(true);

    }


    public function reminder_export(Request $request)
    {
        $last_report_id = report::orderBy('id', 'desc')->first();
        if ($last_report_id) {
            $report_id = Auth::user()->id . Auth::user()->account_type . $last_report_id->id;
        } else {
            $report_id = Auth::user()->id . Auth::user()->account_type . '0';
        }
        $new_report = new report();
        $new_report->user_id = Auth::user()->id;
        $new_report->user_type = Auth::user()->account_type;
        $new_report->report_type = 1;
        $new_report->report_name = 'Reminder-' . $report_id;
        $new_report->facility_id = $request->all_prc_data;
        $new_report->is_completed = 1;
        $new_report->save();

//dd($new_report);
        $providers = $request->all_prov_name;
      //  dd($providers);

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
       // dd($contracts);
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

       // dd($status);

        return back()->with('success', 'Reminder Export Added Successfully');


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
