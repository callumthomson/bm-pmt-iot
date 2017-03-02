<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return $devices;
        //return view('device.index', ['devices' => $devices]);
    }
}
