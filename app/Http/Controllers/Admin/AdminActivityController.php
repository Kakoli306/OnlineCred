<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function account_activity()
    {
        return view('admin.activity.accountActivity');
    }
}
