<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class rolesController extends Controller
{
    public function index()
    {
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $roles = Roles::orderBy('id', 'desc')->withCount('users')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        return view('roles.create');
    }

    public function store(Request $request)
    {
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $validator = Validator::make($request->all(), [
            'role_name' => ['required', 'string', 'max:191', 'unique:roles,role_name']
        ],[
            'role_name.required' => 'Tên vai trò không được bỏ trống.',
            'role_name.unique' => 'Tên vai trò đã được sử dụng.',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        else{
            $roles = new Roles();
            $roles->role_name = $request->input('role_name');
            $roles->description = $request->input('description');
            $roles->role_delegation = $request->input('role_delegation');
            $roles->save();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Thêm vai trò mới <b>". $request->input('role_name')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }

    public function edit($id)
    {
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $data = Roles::findOrFail($id);
        return view('roles.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $roles = Roles::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'role_name' => ['required', 'string', 'max:191', 'unique:roles,role_name,'.$roles->id.',id'],
            'role_delegation.*' => ['required'],
        ],[
            'role_name.required' => 'Tên vai trò không được bỏ trống.',
            'role_name.unique' => 'Tên vai trò đã được sử dụng.',
            'role_delegation.*.required' => ['Phân quyền chức năng không được bỏ trống'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        else{
            $roles->role_name = $request->input('role_name');
            $roles->description = $request->input('description');
            $roles->role_delegation = $request->input('role_delegation');
            $roles->update();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Cập nhật thông tin vai trò <b>". $request->input('role_name')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }
}
