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
        $reminders = reminder::where('followup_date', $today_date)
            ->where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->orderBy('id', 'desc')->paginate(20);
        return view('baseStaff.reminders.reminderList', compact('reminders'));
    }
}

