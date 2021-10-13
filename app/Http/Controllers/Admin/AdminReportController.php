<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function report()
    {
        return view('admin.report.report');
    }
}
