<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\GiveNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reportsController extends Controller
{
    public function index()
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("bc", explode(",", $role)), 401);

        $baocao = GiveNum::orderBy("id", "desc")->get();
        return view('reports.index', compact('baocao'));
    }
}
