<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class activityLogsController extends Controller
{
    public function index(){
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("nk", explode(",", $role)), 401);

        $data = ActivityLogs::orderBy('id', 'desc')->get();
        return view('activity_logs.index', compact('data'));
    }
}
