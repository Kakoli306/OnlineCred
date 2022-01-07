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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function test_update_data()
    {

        $date = Carbon::now()->subDay(1)->format('Y-m-d');
        $practice = reminder::where('followup_date', null)
            ->count();

        return $practice;
        exit();
//        foreach ($practice as $prc) {
//            $sing_prc = reminder::where('id', $prc->id)->first();
//            if ($sing_prc) {
//                if ($sing_prc->followup_date == null || $sing_prc->followup_date == '') {
//                    $sing_prc->followup_date = Carbon::parse($sing_prc->created_at)->format('Y-m-d');
//                    $sing_prc->save();
//                }
//            }
//        }


        return 'done';
        exit();

    }
}
