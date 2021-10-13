<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminReminderController extends Controller
{
    public function reminder()
    {
        return view('admin.reminder.reminderList');
    }
}
