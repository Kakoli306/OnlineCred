<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountManagerController extends Controller
{
    public function index()
    {
        return view('accountManager.index');
    }
}
