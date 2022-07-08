<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Roles;
use App\Models\Services;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class servicesController extends Controller
{
    public function index()
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("dv", explode(",", $role)), 401);

        $services = Services::orderBy('id', 'desc')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("dv_action", explode(",", $role)), 401);

        return view("services.create");
    }

    public function store(Request $request)
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("dv_action", explode(",", $role)), 401);

        $validator = Validator::make($request->all(),[
            'service_code' => ['required', 'unique:services,service_code'],
            'service_name' => ['required', 'unique:services,service_name,'],
        ],[
            'service_code.required' => 'Mã dịch vụ không được để trống.',
            'service_code.unique' => 'Mã dịch vụ đã được sử dụng',
            'service_name.required' => 'Tên dịch vụ không được để trống.',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else{
            $service = new Services();
            $service->service_code = $request->input('service_code');
            $service->service_name = $request->input('service_name');
            $service->description = $request->input('description');
            $service->status = 1;
            if($request->input('number_from') != '') $service->number_from = $request->input('number_from');
            if($request->input('number_to') != '') $service->number_to = $request->input('number_to');
            if($request->input('prefix') != '') $service->prefix = $request->input('prefix');
            if($request->input('surfix') != '') $service->surfix = $request->input('surfix');
            if($request->has('reset')) $service->reset = 0;
            else $service->reset = null;
            $service->save();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Thêm mới dịch vụ <b>". $request->input('service_name')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }

    public function show($id)
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("dv_action", explode(",", $role)), 401);

        $service = Services::with('give_num')->findOrFail($id);
        return view('services.detail', compact('service'));
    }

    public function edit($id)
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("dv_action", explode(",", $role)), 401);

        $service = Services::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        //Authorized
        $role = Roles::where('id', Auth::user()->id)->first()->role_delegation;
        abort_if(!in_array("dv_action", explode(",", $role)), 401);

        $service = Services::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'service_code' => ['required', 'unique:services,service_code,'.$service->id.',id'],
            'service_name' => ['required', 'unique:services,service_name,'.$service->id.',id'],
        ],[
            'service_code.required' => 'Mã dịch vụ không được để trống.',
            'service_code.unique' => 'Mã dịch vụ đã được sử dụng',
            'service_name.required' => 'Tên dịch vụ không được để trống.',
            'service_name.unique' => 'Tên dịch vụ đã được sử dụng',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else{
            $service->service_code = $request->input('service_code');
            $service->service_name = $request->input('service_name');
            $service->description = $request->input('description');
            $service->status = $request->input('status');
            $service->number_from = $request->input('number_from');
            $service->number_to = $request->input('number_to');
            $service->prefix = $request->input('prefix');
            $service->surfix = $request->input('surfix');
            if($request->has('reset')) $service->reset = 0;
            else $service->reset = null;
            $service->update();

            $activity_logs = new ActivityLogs();
            $activity_logs->username = Auth::user()->username;
            $activity_logs->ip_address = $request->ip();
            $activity_logs->description = "Cập nhật dịch vụ <b>". $request->input('service_name')."</b>";
            $activity_logs->created_at = Carbon::now();
            $activity_logs->updated_at = Carbon::now();
            $activity_logs->save();
        }
    }
}
