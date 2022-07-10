<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Roles;
use App\Models\Devices;
use App\Models\ActivityLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class devicesController extends Controller
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

        $data = Devices::orderBy('id', 'desc')->get();
        return view('devices.index', compact('data'));
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

        return view('devices.create');
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

        Validator::extend('checkHashedPass', function($attribute, $value, $parameters){
            if(!Hash::check($value , Auth::user()->password)) return false;
            return true;
        }, 'Không trùng khớp với mật khẩu hiện tại.');

        $validator = Validator::make($request->all(), [
            'device_code' => ['required'],
            'device_type' => ['required'],
            'device_name' => ['required'],
            'username' => ['required', 'in:'. Auth::user()->username],
            'ip_address' => ['required'],
            'password' => ['required', 'checkHashedPass:'. $request->input('password')],
            'description' => ['required'],
        ],[
            'device_code.required' => "Mã thiết bị không được để trống.",
            'device_type.required' => 'Loại thiết bị không được để trống.',
            'device_name.required' => 'Tên thiết bị không được để trống.',
            'username.required' => "Tên đăng nhập không được để trống.",
            'username.in' => "Không trùng khớp với tài khoản đang sử dụng",
            'ip_address.required' => "Địa chỉ IP không được để trống.",
            'password.required' => "Mật khẩu không được để trống.",
            'description.required' => "Dịch vụ sử dụng không được để trống.",
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $devices = new Devices();
            $devices->device_code = $request->input('device_code');
            $devices->device_name = $request->input('device_name');
            $devices->device_type = $request->input('device_type');
            $devices->ip_address = $request->input('ip_address');
            $devices->status = 1;
            $devices->connection = 1;
            $devices->username = $request->input('username');
            $devices->password = $request->input('password');

            $x = null;
            foreach($request->description as $key => $value){
                $x .= $value . ", ";
            }
            $devices->description = $x;
            $devices->save();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Thêm mới thiết bị <b>". $request->input('device_name')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }

    public function show($id)
    {
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $data = Devices::findOrFail($id);
        return view('devices.detail', compact('data'));
    }

    public function edit($id)
    {
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $data = Devices::findOrFail($id);
        return view('devices.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        Validator::extend('checkHashedPass', function($attribute, $value, $parameters){
            if(!Hash::check($value , Auth::user()->password)) return false;
            return true;
        }, 'Không trùng khớp với mật khẩu hiện tại.');

        $validator = Validator::make($request->all(), [
            'device_code' => ['required'],
            'device_type' => ['required'],
            'device_name' => ['required'],
            'username' => ['required', 'in:'. Auth::user()->username],
            'ip_address' => ['required'],
            'password' => ['required', 'checkHashedPass:'. $request->input('password')],
            'description' => ['required'],
        ],[
            'device_code.required' => "Mã thiết bị không được để trống.",
            'device_type.required' => 'Loại thiết bị không được để trống.',
            'device_name.required' => 'Tên thiết bị không được để trống.',
            'username.required' => "Tên đăng nhập không được để trống.",
            'username.in' => "Không trùng khớp với tài khoản đang sử dụng",
            'ip_address.required' => "Địa chỉ IP không được để trống.",
            'password.required' => "Mật khẩu không được để trống.",
            'description.required' => "Dịch vụ sử dụng không được để trống.",
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $devices = Devices::findOrFail($id);
            $devices->device_code = $request->input('device_code');
            $devices->device_name = $request->input('device_name');
            $devices->device_type = $request->input('device_type');
            $devices->ip_address = $request->input('ip_address');
            $devices->status = $request->input('status');
            $devices->connection = $request->input('connection');
            $devices->username = $request->input('username');
            $devices->password = $request->input('password');

            $x = null;
            foreach($request->description as $key => $value){
                $x .= $value . ", ";
            }
            $devices->description = $x;
            $devices->update();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Cập nhật thiết bị <b>". $request->input('device_name')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }
}
