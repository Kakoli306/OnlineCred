<?php

namespace App\Http\Controllers;

use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\assign_practice;
use App\Models\assign_practice_user;
use App\Models\BaseStaff;
use App\Models\contract_status;
use App\Models\practice;
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


        $practice = practice::all();

        foreach ($practice as $pc) {
            $single_prc = practice::where('id', $pc->id)->first();
            if ($single_prc) {
                $ass_prc = new assign_practice_user();
                $ass_prc->user_id = 1;
                $ass_prc->user_type = 1;
                $ass_prc->practice_id = $single_prc->id;
                $ass_prc->save();
            }

        }

        return 'done';
        exit();

    }
}
