<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles;
use App\Models\Devices;
use App\Models\GiveNum;
use App\Models\Services;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class giveNumController extends Controller
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

        $services = Services::select('id', 'service_name')->get();
        $give_num = GiveNum::with('services')->orderBy("id", "desc")->get();
        return view('give_num.index', compact('services', 'give_num'));
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

        $services = Services::select('id', 'service_name')->get();
        return view('give_num.create', compact('services'));
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
            'service' => ['required'],
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
        ],[
            'service.required' => "Vui lòng chọn dịch vụ.",
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'phone.required' => 'Vui lòng nhập SĐT khách hàng.',
            'email.required' => 'Vui lòng nhập email khách hàng.',
            'email.email' => 'Sai định dạng email',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }else{
            $getService = Services::where('id', $request->input('service'))->first();
            $getDevice = Devices::where('connection', 0)
            ->where(function($getDevice) use($getService){
                $getDevice->orWhere('description', 'LIKE', "%$getService->service_name%");
            })->first();
            if($getDevice)
            {
                $give_num = new GiveNum();
                $givenum_based_on_services = GiveNum::where('services_id', $getService->id);

                if($givenum_based_on_services->count() <= 0)
                {
                    $getService->status = 0; //Hoạt động nếu như tổng số lượng cấp số của dịch vụ đó nhỏ hơn hoặc bằng 0
                    $getService->update();
                    $give_num->order = $getService->service_code . $getService->number_from;
                }
                else
                {
                    $latest = $givenum_based_on_services->max('order');
                    if($getService->number_to != null && $latest + $getService->prefix > $getService->service_code . $getService->number_to)
                    {
                        $getService->status = 1; //Ngưng hoạt động nếu như giá trị tối đa khác null hoặc rỗng và giá trị cấp số tiếp theo lớn hơn hoặc bằng giá trị tối đa
                        $getService->update();
                        return response()->json([
                            'status' => 401,
                            'error' => 'Đã đạt đến giới hạn tối đa cấp số của dịch vụ.',
                        ]);
                    }
                    if($getService->reset == 0)
                    {
                        $dailyReset = $givenum_based_on_services->orderBy('id', 'desc')->first()->created_at->startOfDay()->format("Y-m-d H:i:s");
                        if(strtotime($dailyReset) < strtotime(Carbon::now()->startOfDay())){
                            $give_num->order = $getService->service_code . $getService->number_from;
                        }
                        elseif(strtotime($dailyReset) == strtotime(Carbon::now()->startOfDay()))
                        {
                            $give_num->order = $givenum_based_on_services->orderBy('created_at', 'desc')->first()->order + $getService->prefix;
                        }
                    }
                    else
                    {
                        $getService->status = 0; //Hoạt động nếu như giá trị tối đa bằng null hoặc rỗng và chưa đạt đến giá trị tối đa.
                        $getService->update();
                        $give_num->order = $latest + $getService->prefix;
                    }
                }

                $give_num->name = $request->input('name');
                $give_num->phone = $request->input('phone');
                $give_num->email = $request->input('email');
                $give_num->services_id = $request->input('service');
                $give_num->status = 0;
                $now = Carbon::now();
                $expired_date = Carbon::now()->hour(17)->minute(30)->second(0);

                if($now > $expired_date)
                {
                    $give_num->expired_date = $expired_date->addDays(1);
                }
                else
                {
                    $give_num->expired_date = $expired_date;
                }

                if(in_array(strtolower($getService->service_name), explode(",", strtolower($getDevice->description))))
                {
                    $give_num->supply = $getDevice->device_name;
                }
                else
                {
                    return response()->json([
                        'status' => 401,
                        'error' => "Hiện không có nguồn cấp nào cho dịch vụ được chọn.",
                    ]);
                }
                $give_num->save();
                return response()->json(
                    [
                        'id' => $give_num->id,
                        'order' => $give_num->order,
                        'service_id' => $give_num->services_id,
                        'service_name' => $getService->service_name,
                        'created_at' => $now->format("H:i d/m/Y"),
                        'expired_date' => $give_num->expired_date->format("H:i d/m/Y"),
                        'device_id' => $getDevice->id,
                    ]
                );

                $activity_logs = new ActivityLogs();
                $activity_logs->username = Auth::user()->username;
                $activity_logs->ip_address = $request->ip();
                $activity_logs->description = "Cấp số mới <b>". $give_num->order."</b>";
                $activity_logs->created_at = $now;
                $activity_logs->updated_at = $now;
                $activity_logs->save();
            }
            else
            {
                return response()->json([
                    'status' => 401,
                    'error' => 'Hiện không có thiết bị tương ứng với dịch vụ vừa chọn có thể sử dụng.'
                ]);
            }
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

        $data = GiveNum::findOrFail($id);
        return view('give_num.detail', compact('data'));
    }
}
