<?php

namespace App\Http\Controllers\BaseStaff;

use App\Http\Controllers\Controller;
use App\Models\reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseStaffReminderController extends Controller
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
        return view('baseStaff.reminders.reminderList', compact('reminders'));
    }
}

