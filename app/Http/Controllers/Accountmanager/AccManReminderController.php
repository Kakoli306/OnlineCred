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
        $reminders = reminder::where('followup_date', $today_date)
            ->where('user_id', Auth::user()->id)
            ->where('user_type', Auth::user()->account_type)
            ->orderBy('id', 'desc')->paginate(20);
        return view('accountManager.reminders.reminderList', compact('reminders'));
    }
}
