<?php

namespace App\Http\Controllers\BaseStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseStaffReminderController extends Controller
{
    public function reminders()
    {
        return view('baseStaff.reminders.reminderList');
    }
}
