<?php

namespace App\Http\Controllers\BaseStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseStaffAccActivityController extends Controller
{
    public function account_activity()
    {
        return view('baseStaff.activity.accountActivity');
    }
}
