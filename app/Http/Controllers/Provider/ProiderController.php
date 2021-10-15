<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\assign_practice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProiderController extends Controller
{
    public function index()
    {
        $assign_prac = assign_practice::where('provider_id',Auth::user()->id)->paginate(20);
        return view('provider.index',compact('assign_prac'));
    }
}
