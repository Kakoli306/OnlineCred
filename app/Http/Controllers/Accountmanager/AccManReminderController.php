<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use App\Models\provider_contract_note;
use App\Models\reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccManReminderController extends Controller
{
    public function reminders()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $userid = Auth::user()->id;
        $userType = Auth::user()->account_type;

        $reminders = reminder::where('followup_date', $today_date)
            ->where(function ($query) use ($userid, $userType) {
                $query->where('user_id', $userid);
                $query->where('user_type', $userType);
            })
            ->orWhere(function ($query) use ($userid, $userType) {
                $query->where('assignedto_user_id', $userid);
                $query->where('assignedto_user_type', $userType);
            })
            ->orderBy('id', 'desc')->paginate(20);
        return view('accountManager.reminders.reminderList', compact('reminders'));
    }
}
