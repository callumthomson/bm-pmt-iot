<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;

class DeviceController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $devices = Device::all();
        return view('device.index', [
            'devices' => $devices
        ]);
    }

    public function getCreatePage()
    {
        return view('device.create');
    }

    public function getDevicePage($device_id)
    {

    }

    public function getUpdatePage($device_id)
    {

    }

    public function getDeletePage($device_id)
    {
        $device = Device::findOrFail($device_id);
        return view('device.delete', ['device' => $device]);
    }

    public function postDeletePage($device_id)
    {
        $device = Device::findOrFail($device_id);
        $device->delete();
        return redirect('/devices');
}

    public function showMessages($device_id)
    {
        $device = Device::findorFail($device_id);
        return $device->messages;
    }
}
