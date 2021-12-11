<?php

namespace App\Console\Commands;

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

        $reports = report::where('is_completed', 1)->get();

        foreach ($reports as $report) {
            $single_report = report::where('id', $report->id)->get();
            $name = public_path('report/' . $report->report_name . ".csv");
            $report_data = (new FastExcel($single_report))->export($name, function ($line) {
                $fac = practice::where('id', $line->facility_id)->first();
                $prov = Provider::where('id', $line->provider_id)->first();
                $con = provider_contract::where('id', $line->contact_id)->first();
                $notes = provider_contract_note::where('contract_id', $line->contact_id)
                    ->where('status', $line->status)
                    ->get();

                $array = ['note' => null];

                foreach ($notes as $note) {
                    $w_date = Carbon::parse($note->worked_date)->format('m/d/Y');
                    array_push($array, $array['note'] .= $w_date . ' ' . $note->note . '\r\n');
                }

                return [
                    'Facility' => isset($fac) ? $fac->business_name : "",
                    'Provider Name' => isset($prov) ? $prov->full_name : "",
                    'Contract Name' => isset($con) ? $con->contract_name : '',
                    'Contract Type' => isset($con) ? $con->contract_name : '',
                    'Status' => $line->status,
                    'Notes' => $array['note'],
                    'Follow Up Date' => $array['note'],
                ];
            });

            $report_update = report::where('id', $report->id)->first();
            $report_update->is_completed = 2;
            $report_update->save();
        }


    }
}
