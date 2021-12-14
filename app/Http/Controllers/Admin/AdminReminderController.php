<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\provider_contract_note;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReminderController extends Controller
{
    public function reminder()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $all_notes = provider_contract_note::where('admin_id', Auth::user()->id)
            ->where('followup_date', '<=', $today_date)
            ->paginate(20);
        return view('admin.reminder.reminderList', compact('all_notes'));
    }
}
