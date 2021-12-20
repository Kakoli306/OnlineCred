<?php

namespace App\Http\Controllers;

use App\Models\assign_practice;
use App\Models\contract_status;
use App\Models\Provider;
use App\Models\provider_contract;
use App\Models\provider_contract_note;
use App\Models\provider_document;
use App\Models\provider_document_type;
use App\Models\reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function test_update_data()
    {


        $all_contract = provider_contract_note::all();

        foreach ($all_contract as $con) {

            $sing_con = provider_contract_note::where('id', $con->id)->first();
            if ($sing_con) {
                $new_reminder_user = new reminder();
                $new_reminder_user->user_id = 1;
                $new_reminder_user->user_type = 1;
                $new_reminder_user->provider_id = $sing_con->provider_id;
                $new_reminder_user->facility_id = $sing_con->facility_id;
                $new_reminder_user->contract_id = $con->contract_id;
                $new_reminder_user->note_id = $con->id;
                $new_reminder_user->followup_date = $sing_con->contract_followup_date;
                $new_reminder_user->worked_date = $sing_con->worked_date;
                $new_reminder_user->status = $sing_con->status;
                $new_reminder_user->is_note = 1;
                $new_reminder_user->save();
            }


        }


        return 'done';
        exit();

    }
}
