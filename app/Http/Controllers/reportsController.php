<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use App\Models\GiveNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class reportsController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $baocao = GiveNum::orderBy("id", "desc")->get();
        return view('reports.index', compact('baocao'));
    }
}
