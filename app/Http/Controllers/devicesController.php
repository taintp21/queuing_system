<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use Illuminate\Http\Request;

class devicesController extends Controller
{
    public function index()
    {
        $data = Devices::orderBy('id', 'desc')->get();
        return view('devices.index', compact('data'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $devices = new Devices();
        $devices->device_code = $request->input('device_code');
        $devices->device_name = $request->input('device_name');
        $devices->device_type = $request->input('device_type');
        $devices->ip_address = $request->input('ip_address');
        $devices->status = 2;
        $devices->connection = 2;
        $devices->username = $request->input('username');
        $devices->password = $request->input('password');
        $devices->description = $request->input('description');
        $devices->save();
    }

    public function show($id)
    {
        $data = Devices::find($id);
        return view('devices.detail', compact('data'));
    }

    public function edit($id)
    {
        $data = Devices::find($id);
        return view('devices.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Devices::find($id);
        $data->device_code = $request->input('device_code');
        $data->device_name = $request->input('device_name');
        $data->device_type = $request->input('device_type');
        $data->ip_address = $request->input('ip_address');
        $data->status = $request->input('status');
        $data->connection = $request->input('connection');
        $data->username = $request->input('username');
        $data->password = $request->input('password');
        $data->description = $request->input('description');
        $data->update();
    }

    // public function destroy($id)
    // {
    //     Devices::destroy($id);
    //     return back()->with("success", "Xoá thành công!");
    // }
}
