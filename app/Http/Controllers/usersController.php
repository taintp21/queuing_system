<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    public function index(){
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $data = User::orderBy('id','desc')->with('role')->get();
        $roles = Roles::all();
        return view('users.index', compact('data','roles'));
    }

    public function create(){
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $roles = Roles::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required','string','max:191','unique:users,username'],
            'name' => ['required','max:191'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['required','regex:/^((\+)33|0)[1-9](\d{2}){4}$/'],
            'password' => ['required','string','min:6'],
            'password_confirmation' => ['required','same:password','min:6'],
        ],[
            'username.required' => "Tên đăng nhập không được để trống!",
            'username.string' => "Tên đăng nhập phải là chuỗi ký tự!",
            'username.max' => "Tối đa 191 ký tự!",
            "username.unique" => "Tên đăng nhập đã được sử dụng!",
            'name.required' => "Họ tên không được để trống!",
            'name.max' => "Tối đa 191 ký tự!",
            'email.required' => "Email không được để trống!",
            'email.email' => "Email không hợp lệ!",
            'email.unique' => "Email đã được sử dụng!",
            'phone.required' => "Số điện thoại không được để trống!",
            'phone.regex' => "Sai định dạng số điện thoại VN",
            'password.required' => "Mật khẩu không được để trống!",
            'password.min' => "Tối thiểu 6 ký tự!",
            'password_confirmation.required' => "Nhập lại mật khẩu không được để trống!",
            'password_confirmation.same' => "Mật khẩu không trùng khớp!",
            'password_confirmation.min' => "Tối thiểu 6 ký tự!",
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $user = new User();
            $user->username = $request->input('username');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->avatar = 'default-avatar.png';
            $user->password = bcrypt($request->input('password'));
            $user->roles_id = $request->input('roles_id');
            $user->status = $request->input('status');
            $user->save();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Thêm mới tài khoản <b>". $request->input('username')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }
    public function edit($id){
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $data = User::findOrFail($id);
        $roles = Roles::all();
        return view('users.edit', compact('data', 'roles'));
    }

    public function update(Request $request, $id){
        //Authorized
        $user_id = Auth::user()->id;
        $role = Roles::where('id', $user_id)->first()->role_delegation;
        $user_role = User::where('id', $user_id)->first()->roles_id;
        if(!in_array("tb", explode(",", $role)) || $user_role == null){
            abort(401);
        }

        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'username' => ['required','string','max:191','unique:users,username,'.$user->id.',id'],
            'name' => ['required','max:191'],
            'email' => ['required','email','unique:users,email,'.$user->id.',id'],
            'phone' => ['required','regex:/^((\+)33|0)[1-9](\d{2}){4}$/'],
            'password' => ['required', 'string', 'min:6,'],
            'password_confirmation' => ['required','same:password','min:6'],
        ],[
            'username.required' => "Tên đăng nhập không được để trống!",
            'username.string' => "Tên đăng nhập phải là chuỗi ký tự!",
            'username.max' => "Tối đa 191 ký tự!",
            "username.unique" => "Tên đăng nhập đã được sử dụng!",
            'name.required' => "Họ tên không được để trống!",
            'name.max' => "Tối đa 191 ký tự!",
            'email.required' => "Email không được để trống!",
            'email.email' => "Email không hợp lệ!",
            'email.unique' => "Email đã được sử dụng!",
            'phone.required' => "Số điện thoại không được để trống!",
            'phone.regex' => "Sai định dạng số điện thoại VN",
            'password.min' => "Tối thiểu 6 ký tự!",
            'password_confirmation.required' => "Nhập lại mật khẩu không được để trống!",
            'password_confirmation.same' => "Mật khẩu không trùng khớp!",
            'password_confirmation.min' => "Tối thiểu 6 ký tự!",
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $user->username = $request->input('username');
            $user->name = $request->input('name');
            $user->avatar = $request->input('avatar');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');

            if($user->password == $request->input('password')) $user->password = $request->input('password');
            else $user->password = Hash::make($request->input('password'));

            $user->roles_id = $request->input('roles_id');
            $user->status = $request->input('status');
            $user->update();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Cập nhật thông tin tài khoản <b>". $request->input('username')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }
}
