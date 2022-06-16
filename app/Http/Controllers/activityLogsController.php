<?php

namespace App\Http\Controllers;

use App\Models\ActivityLogs;
use Illuminate\Http\Request;

class activityLogsController extends Controller
{
    public function index(){
        $data = ActivityLogs::orderBy('id', 'desc')->paginate(9);
        return view('activity_logs.index', compact('data'));
    }
}
