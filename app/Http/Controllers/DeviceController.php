<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;
use App\DeviceType;
use Carbon\Carbon;

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

    public function postCreatePage(Request $request)
    {
        $device = new Device([
            'name' => $request->input('txt-name'),
            'type_id' => $request->input('sel-type'),
        ]);
        $device->save();
        return redirect('/devices');
    }

    public function getDevicePage(Request $request, $device_id)
    {
        $device = Device::findOrFail($device_id);
        return view('device.view', [
            'device' => $device
        ]);
    }

    public function getUpdatePage($device_id)
    {
        $device = Device::findOrFail($device_id);
        return view('device.update', [
           'device' => $device
        ]);
    }

    public function postUpdatePage($device_id)
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
  
    public function getDeviceData($device_id){
        $device = Device::findorFail($device_id);
        $filtered = $device->messages->filter(function($value, $key){
            return $value->created_at->gt(Carbon::now()->subHours(24));
        })->values();
        $device->data = $filtered;
        return $device;
    }
  
    public function getDeviceExpectedData($device_id){
        $device = Device::findorFail($device_id);
        return DeviceType::findorFail($device->type_id);
    }
}














