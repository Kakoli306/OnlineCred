<?php

namespace App\Http\Controllers\BaseStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseStaffController extends Controller
{
    public function index()
    {
        return view('baseStaff.index');
    }
}
