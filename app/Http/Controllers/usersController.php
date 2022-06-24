<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    public function index(){
        $data = User::with('role')->get();
        $roles = Roles::all();
        return view('users.index', compact('data','roles'));
    }

    public function create(){
        $roles = Roles::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => ['required','string','max:191','unique:users,username'],
            'name' => ['required','max:191'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['required','regex:/^((\+)33|0)[1-9](\d{2}){4}$/'],
            'password' => ['required','min:6'],
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
            $data = new User();
            $data->username = $request->input('username');
            $data->name = $request->input('name');
            $data->email = $request->input('email');
            $data->phone = $request->input('phone');
            $data->password = bcrypt($request->input('password'));
            $data->roles_id = $request->input('roles_id');
            $data->status = $request->input('status');
            $data->save();
            return response()->json([
                'status' => 200,
            ]);
        }
    }
    public function edit($id){
        $data = User::find($id);
        $roles = Roles::all();
        return view('users.edit', compact('data', 'roles'));
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'username' => ['required','string','max:191','unique:users,username'],
            'name' => ['required','max:191'],
            'email' => ['required','email','unique:users,email'],
            'phone' => ['required','nullable','regex:/^((\+)33|0)[1-9](\d{2}){4}$/'],
            'password' => ['required','min:6'],
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
            $data = User::find($id);
            $data->username = $request->input('username');
            $data->name = $request->input('name');
            $data->avatar = $request->input('avatar');
            $data->email = $request->input('email');
            $data->phone = $request->input('phone');
            $data->password = bcrypt($request->input('password'));
            $data->roles_id = $request->input('roles_id');
            $data->status = $request->input('status');
            $data->update();
            return response()->json([
                'status' => 200,
            ]);
        }
    }
}
