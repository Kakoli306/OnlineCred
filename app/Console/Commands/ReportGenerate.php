<?php

namespace App\Console\Commands;

use App\Models\contact_type;
use App\Models\insurance;
use App\Models\practice;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\report;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Report';

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
//        return 0;

//        $reports = report::where('is_completed', 1)->get();
        $reports = report::all();

        foreach ($reports as $report) {
            $single_report = report::where('id', $report->id)->first();
            $name = public_path('report/' . $report->report_name . ".csv");

            $contracts = provider_contract_note::distinct()->select('admin_id', 'facility_id', 'provider_id', 'contract_id', 'status')->where('admin_id', $single_report->admin_id)
                ->where('facility_id', $single_report->facility_id)
                ->where('followup_date', '>=', $single_report->form_date)
                ->where('followup_date', '<=', $single_report->to_date)
                ->get();

            $report_data = (new FastExcel($contracts))->export($name, function ($line) {

                $fac = practice::where('id', $line->facility_id)->first();
                $prov = Provider::where('id', $line->provider_id)->first();
                $con = provider_contract::where('id', $line->contract_id)->first();
                $con_type = contact_type::where('id', $con->contract_type)->first();
                $notes = provider_contract_note::where('admin_id', $line->admin_id)
                    ->where('provider_id', $line->provider_id)
                    ->where('facility_id', $line->facility_id)
                    ->where('contract_id', $line->contract_id)
                    ->get();

                $single_note_last_followup = provider_contract_note::where('admin_id', $line->admin_id)
                    ->where('provider_id', $line->provider_id)
                    ->where('facility_id', $line->facility_id)
                    ->where('contract_id', $line->contract_id)
                    ->orderBy('followup_date', 'desc')
                    ->first();


                $array = ['note' => null];

                foreach ($notes as $note) {
                    $w_date = Carbon::parse($note->worked_date)->format('m/d/Y');
                    array_push($array, $array['note'] .= $w_date . ' ' . $note->note);
                }

                return [
                    'Facility' => isset($fac) ? $fac->business_name : "",
                    'Provider Name' => isset($prov) ? $prov->full_name : "",
                    'Contract Name' => isset($con) ? $con->contract_name : '',
                    'Contract Type' => isset($con_type) ? $con_type->contact_type : '',
                    'Status' => $line->status,
                    'Notes' => $array['note'],
                    'Follow Up Date' => isset($single_note_last_followup) ? Carbon::parse($single_note_last_followup->followup_date)->format('m/d/Y') : '',
                ];
            });

            $report_update = report::where('id', $report->id)->first();
            $report_update->is_completed = 2;
            $report_update->save();
        }


    }
}
