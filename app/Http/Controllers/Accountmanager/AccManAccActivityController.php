<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccManAccActivityController extends Controller
{
    public function account_activity()
    {
        return view('accountManager.activity.accountActivity');
    }
}
