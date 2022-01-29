<?php

namespace App\Http\Controllers\Accountmanager;

use App\Http\Controllers\Controller;
use App\Models\report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AccManDownloadController extends Controller
{
    public function download_files()
    {
        $reports = report::where('user_id', Auth::user()->id)->where('user_type', Auth::user()->account_type)->paginate(10);
        return view('accountManager.download.downloadFiles', compact('reports'));
    }


    public function download_reminder_files($id)
    {
        $report = report::where('id', $id)->first();
        return Response::download(public_path("reminder/" . $report->report_name . ".csv"));
    }
}
