<?php

namespace App\Http\Controllers;

use App\Models\AccountManager;
use App\Models\Admin;
use App\Models\assign_practice;
use App\Models\BaseStaff;
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


        $notes = provider_contract_note::all();
        foreach ($notes as $note) {
            $single_note = provider_contract_note::where('id', $note->id)->first();

            if ($single_note->user_type == 1) {
                $admin = Admin::where('id', $single_note->user_id)->first();
                if ($admin) {
                    $single_note->user_name = $admin->name;
                    $single_note->save();
                }
            } elseif ($single_note->user_type == 2) {
                $admin = AccountManager::where('id', $single_note->user_id)->first();
                if ($admin) {
                    $single_note->user_name = $admin->name;
                    $single_note->save();
                }
            } elseif ($single_note->user_type == 3) {
                $admin = BaseStaff::where('id', $single_note->user_id)->first();
                if ($admin) {
                    $single_note->user_name = $admin->name;
                    $single_note->save();
                }
            } else {

            }

        }

        return 'done';
        exit();

    }
}
