<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GiveNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dacap = GiveNum::count();
        $waiting = GiveNum::where('status', 0)->count();
        $used = GiveNum::where('status', 1)->count();
        $skip = GiveNum::where('status', 2)->count();

        $dbData = [];
        $days = GiveNum::select(DB::raw('DATE(created_at) as time'), DB::raw('count(*) as count'))
                                    ->whereDate('created_at', '>=', Carbon::now()->startOfMonth()->format("Y-m-d H:i:s"))
                                    ->whereDate('created_at', '<=', date(Carbon::now()->format("Y-m-d H:i:s")))
                                    ->groupBy('time')->get();

        $month = GiveNum::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $lastMonth = GiveNum::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->count();
        $last2Months = GiveNum::whereBetween('created_at', [Carbon::now()->subMonth(2)->startOfMonth(), Carbon::now()->subMonth(2)->endOfMonth()])->count();
        $last3Months = GiveNum::whereBetween('created_at', [Carbon::now()->subMonth(3)->startOfMonth(), Carbon::now()->subMonth(3)->endOfMonth()])->count();

        $week = GiveNum::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $lastWeek = GiveNum::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        $last2Weeks = GiveNum::whereBetween('created_at', [Carbon::now()->subWeek(2)->startOfWeek(), Carbon::now()->subWeek(2)->endOfWeek()])->count();
        $last3Weeks = GiveNum::whereBetween('created_at', [Carbon::now()->subWeek(3)->startOfWeek(), Carbon::now()->subWeek(3)->endOfWeek()])->count();
        return view('index', compact('dacap','waiting','used','skip', 'month', 'lastMonth', 'last2Months', 'last3Months' ,'week', 'lastWeek', 'last2Weeks', 'last3Weeks', 'days'));
    }
}
