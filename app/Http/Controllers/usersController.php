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
            'username.required' => "T??n ????ng nh???p kh??ng ???????c ????? tr???ng!",
            'username.string' => "T??n ????ng nh???p ph???i l?? chu???i k?? t???!",
            'username.max' => "T???i ??a 191 k?? t???!",
            "username.unique" => "T??n ????ng nh???p ???? ???????c s??? d???ng!",
            'name.required' => "H??? t??n kh??ng ???????c ????? tr???ng!",
            'name.max' => "T???i ??a 191 k?? t???!",
            'email.required' => "Email kh??ng ???????c ????? tr???ng!",
            'email.email' => "Email kh??ng h???p l???!",
            'email.unique' => "Email ???? ???????c s??? d???ng!",
            'phone.required' => "S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!",
            'phone.regex' => "Sai ?????nh d???ng s??? ??i???n tho???i VN",
            'password.required' => "M???t kh???u kh??ng ???????c ????? tr???ng!",
            'password.min' => "T???i thi???u 6 k?? t???!",
            'password_confirmation.required' => "Nh???p l???i m???t kh???u kh??ng ???????c ????? tr???ng!",
            'password_confirmation.same' => "M???t kh???u kh??ng tr??ng kh???p!",
            'password_confirmation.min' => "T???i thi???u 6 k?? t???!",
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
            $activity_logs->description = "Th??m m???i t??i kho???n <b>". $request->input('username')."</b>";
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
            'username.required' => "T??n ????ng nh???p kh??ng ???????c ????? tr???ng!",
            'username.string' => "T??n ????ng nh???p ph???i l?? chu???i k?? t???!",
            'username.max' => "T???i ??a 191 k?? t???!",
            "username.unique" => "T??n ????ng nh???p ???? ???????c s??? d???ng!",
            'name.required' => "H??? t??n kh??ng ???????c ????? tr???ng!",
            'name.max' => "T???i ??a 191 k?? t???!",
            'email.required' => "Email kh??ng ???????c ????? tr???ng!",
            'email.email' => "Email kh??ng h???p l???!",
            'email.unique' => "Email ???? ???????c s??? d???ng!",
            'phone.required' => "S??? ??i???n tho???i kh??ng ???????c ????? tr???ng!",
            'phone.regex' => "Sai ?????nh d???ng s??? ??i???n tho???i VN",
            'password.min' => "T???i thi???u 6 k?? t???!",
            'password_confirmation.required' => "Nh???p l???i m???t kh???u kh??ng ???????c ????? tr???ng!",
            'password_confirmation.same' => "M???t kh???u kh??ng tr??ng kh???p!",
            'password_confirmation.min' => "T???i thi???u 6 k?? t???!",
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
            $activity_logs->description = "C???p nh???t th??ng tin t??i kho???n <b>". $request->input('username')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }
}
