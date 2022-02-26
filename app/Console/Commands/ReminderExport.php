<?php

namespace App\Console\Commands;

use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\BaseStaff;
use App\Models\contract_status;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\reminder;
use App\Models\report;
use App\Models\report_contract;
use App\Models\report_provider;
use App\Models\report_status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class ReminderExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reminders = report::where('report_type', 1)->where('is_completed', 1)->get();

        foreach ($reminders as $reminder) {
            $name = public_path('reminder/' . $reminder->report_name . ".csv");

            $single_reminder = report::where('id', $reminder->id)->first();


            $facil_id = $reminder->facility_id;

            $providers = report_provider::where('report_id', $reminder->id)->get();
            $provider_array = [];
            foreach ($providers as $pro) {
                array_push($provider_array, $pro->provider_id);
            }


            $contract = report_contract::where('report_id', $reminder->id)->get();
            $contract_array = [];
            foreach ($contract as $con) {
                array_push($contract_array, $con->contract_id);
            }


            $status = report_status::where('report_id', $reminder->id)->get();
            $status_array = [];
            foreach ($status as $sts) {
                array_push($status_array, $sts->status_id);
            }


//            $all_reminder = reminder::where('assignedto_user_id', $reminder->user_id)
//                ->where('assignedto_user_type', $reminder->user_type)
//                ->where(function ($query) use ($facil_id) {
//                    if ($facil_id) {
//                        $query->where('facility_id', $facil_id);
//                    }
//
//                })->orWhere(function ($query) use ($provider_array) {
//                    if ($provider_array) {
//                        $query->whereIn('provider_id', $provider_array);
//                    }
//                })->orWhere(function ($query) use ($contract_array) {
//                    if ($contract_array) {
//                        $query->whereIn('contract_id', $contract_array);
//                    }
//                })->orWhere(function ($query) use ($status_array) {
//                    if ($status_array) {
//                        $query->whereIn('status', $status_array);
//                    }
//                })->get();

            $userid = $reminder->user_id;
            $userType = $reminder->user_type;

            $query = "SELECT * FROM reminders WHERE is_show=1 ";


            if ($userType != 1) {
                $query .= "AND assignedto_user_id=$userid ";
                $query .= "AND assignedto_user_type=$userType ";
            }


            if (isset($facil_id)) {
                $query .= "AND facility_id=$facil_id ";
            }

            if (isset($provider_array)) {
                $PROV_filter = implode("','", $provider_array);
                $query .= "AND provider_id IN('" . $PROV_filter . "') ";
            }

            if (isset($contract_array)) {
                $CON_filter = implode("','", $contract_array);
                $query .= "AND contract_id IN('" . $CON_filter . "') ";
            }


            if (isset($status_array)) {
                $STATUS_filter_DATA = implode("','", $status_array);
                $query .= "AND status IN('" . $STATUS_filter_DATA . "') ";
            }

            $query .= "ORDER BY id DESC";
            $all_reminder = DB::select($query);

            $reminder_data = (new FastExcel($all_reminder))->export($name, function ($line) {


                if ($line->followup_date != null || $line->followup_date != '') {
                    $follow_date = Carbon::parse($line->followup_date)->format('m/d/Y');
                } else {
                    $follow_date = '';
                }


                if ($line->worked_date != null || $line->worked_date != '') {
                    $worked_date = Carbon::parse($line->worked_date)->format('m/d/Y');
                } else {
                    $worked_date = '';
                }

                $fac_name = practice::select('id', 'business_name')->where('id', $line->facility_id)->first();
                $prov_name = Provider::select('id', 'full_name')->where('id', $line->provider_id)->first();
                if($prov_name)
                {
                    if($prov_name->is_active = 1)
                    {
                        $star = '';
                    }
                    else{
                        $star = '*';
                    }
                }
                else 
                {
                    $star = '';
                }
                $con_name = provider_contract::select('id', 'contract_name')->where('id', $line->contract_id)->first();
                $st_name = contract_status::where('id', $line->status)->first();


                $create_by_admin = Admin::where('id', $line->user_id)->where('account_type', $line->user_type)->first();
                $create_by_manager = AccountManager::where('id', $line->user_id)->where('account_type', $line->user_type)->first();
                $create_by_staff = BaseStaff::where('id', $line->user_id)->where('account_type', $line->user_type)->first();

                if ($create_by_admin) {
                    $create_by = 'CreatedBy-' . $create_by_admin->name;
                } elseif ($create_by_manager) {
                    $create_by = 'CreatedBy-' . $create_by_manager->name;
                } elseif ($create_by_staff) {
                    $create_by = 'CreatedBy-' . $create_by_staff->name;
                } else {
                    $create_by = '';
                }


                if ($line->is_assign == 1) {
                    if ($line->assignedto_user_type == 1) {
                        $assignto_admin = \App\Models\Admin::where('id', $line->assignedto_user_id)->first();
                    } elseif ($line->assignedto_user_type == 2) {
                        $assignto_manager = \App\Models\AccountManager::where('id', $line->assignedto_user_id)->first();
                    } elseif ($line->assignedto_user_type == 3) {
                        $assignto_staff = \App\Models\BaseStaff::where('id', $line->assignedto_user_id)->first();
                    }


                    if ($line->assignedto_user_type == 1) {
                        if ($assignto_admin) {
                            $assigned_to = '/ AssignedTo-' . $assignto_admin->name;
                        }
                    } elseif ($line->assignedto_user_type == 2) {
                        if ($assignto_manager) {
                            $assigned_to = '/ AssignedTo-' . $assignto_manager->name;
                        }
                    } elseif ($line->assignedto_user_type == 3) {
                        if ($assignto_staff) {
                            $assigned_to = '/ AssignedTo-' . $assignto_staff->name;
                        }
                    } else {
                        $assigned_to = '';
                    }

                } else {
                    $assigned_to = '';
                }


                return [
                    'Facility' => isset($fac_name) ? $fac_name->business_name : "",
                    'Provider Name' => isset($prov_name) ? $prov_name->full_name : "",
                    'Contract Name' => isset($con_name) ? $con_name->contract_name : "",
                    'Followup Data' => $follow_date,
                    'Worked Data' => $worked_date,
                    'Status' => isset($st_name) ? $st_name->contact_status : "",
                    'CreatedBy/AssignedTo' => $create_by . $assigned_to,

                ];
            });


            $reminder_update = report::where('id', $reminder->id)->first();
            $reminder_update->is_completed = 2;
            $reminder_update->save();


        }

    }
}
