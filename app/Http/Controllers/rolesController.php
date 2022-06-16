<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class rolesController extends Controller
{
    public function index()
    {
        $data = Roles::orderBy('id', 'desc')->with('users')->get();
        return view('roles.index', compact('data'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $roles = new Roles();
        $roles->role_name = $request->input('role_name');
        $roles->description = $request->input('description');
        $roles->role_delegation = $request->input('role_delegation');
        $roles->save();
    }

    public function edit($id)
    {
        $data = Roles::find($id);
        $role_delegations = Roles::select('role_delegation')->where('id',$id)->first();
        return view('roles.edit', compact('data', 'role_delegations'));
    }


    public function update(Request $request, $id)
    {
        $data = Roles::find($id);
        $data->role_name = $request->input('role_name');
        $data->description = $request->input('description');
        $data->role_delegation = $request->input('role_delegation');
        $data->save();
    }


    public function destroy($id)
    {
        //
    }
}
