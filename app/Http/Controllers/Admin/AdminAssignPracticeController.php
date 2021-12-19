<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountManager;
use App\Models\assign_practice;
use App\Models\assign_practice_user;
use App\Models\BaseStaff;
use App\Models\practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAssignPracticeController extends Controller
{
    public function practice_assign_get_all_user(Request $request)
    {
        $type = $request->type_id;
        if ($type == 2) {
            $user = AccountManager::all();
        } elseif ($type == 3) {
            $user = BaseStaff::all();
        }

        return response()->json($user, 200);

    }


    public function practice_assign_show_all_prc(Request $request)
    {
        $prac = assign_practice_user::where('user_id', $request->user_id)
            ->where('user_type', $request->account_type_user)
            ->get();
        $ids = [];
        foreach ($prac as $prc) {
            array_push($ids, $prc->practice_id);
        }

        $get_all_prac = practice::whereNotIn('id', $ids)->get();
        return response()->json($get_all_prac, 200);
    }


    public function practice_assign_show_all_prc_user(Request $request)
    {
        $prac = assign_practice_user::where('user_id', $request->user_id)
            ->where('user_type', $request->account_type_user)
            ->get();
        $ids = [];
        foreach ($prac as $prc) {
            array_push($ids, $prc->practice_id);
        }

        $get_all_prac = practice::whereIn('id', $ids)->get();
        return response()->json($get_all_prac, 200);
    }


    public function practice_assign_user(Request $request)
    {
        $fac_ids = $request->fac_id;
        for ($i = 0; $i < count($fac_ids); $i++) {
            assign_practice_user::create([
                'user_id' => $request->user_id,
                'user_type' => $request->account_type_user,
                'practice_id' => $fac_ids[$i],
            ]);
        }

        return response()->json('done', 200);

    }


    public function practice_assign_remove_prc_for_user(Request $request)
    {
        $assign_prac = $request->assign_prac;
        $account_type_user = $request->account_type_user;
        $user_id = $request->user_id;

        foreach ($assign_prac as $prc) {
            $del_ass_prc = assign_practice_user::where('user_id', $user_id)->where('user_type', $account_type_user)->where('practice_id', $prc)->first();
            if ($del_ass_prc) {
                $del_ass_prc->delete();
            }
        }
    }

}
