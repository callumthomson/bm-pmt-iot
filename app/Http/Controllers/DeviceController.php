<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Device;
use App\DeviceType;
use Carbon\Carbon;

use Validator;

class DeviceController extends Controller
{
    private $validatorMessages = [
        'txt-name.required' => 'You must provide a name',
        'txt-name.max' => 'That name is too long',
    ];

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
        $validator = Validator::make($request->all(), [
            'txt-name' => 'required|max:255',
            'sel-type' => 'required|exists:device_types,id',
        ], $this->validatorMessages);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $device = new Device([
                'name' => $request->input('txt-name'),
                'type_id' => $request->input('sel-type'),
            ]);
            $device->save();
        }
        return redirect('/devices');
    }

    public function getDevicePage(Request $request, $device_id)
    {
        $device = Device::findOrFail($device_id);
		$device->device_type;
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

    public function postUpdatePage(Request $request, $device_id)
    {
        $device = Device::findOrFail($device_id);

        $validator = Validator::make($request->all(), [
            'txt-name' => 'required|max:255',
            'sel-type' => 'required|exists:device_types,id',
        ], $this->validatorMessages);

        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        } else {
            $name = $request->input('txt-name');
            $type = DeviceType::findOrFail($request->input('sel-type'));
            $device->name = $name;
            $device->device_type()->save($type);
            $device->save();
            return redirect('/devices');
        }
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














