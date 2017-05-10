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

    /**
     * Show the devices index page with all the devices
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $devices = Device::all();
        return view('device.index', [
            'title' => 'Devices',
            'devices' => $devices
        ]);
    }

    /**
     * Show the device creation page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreatePage()
    {
        return view('device.create', [
            'title' => 'Create Device'
        ]);
    }

    /**
     * Handle a device creation request POSTed from the device creation page.
     * Validate the data and attempt to create the device.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Show the device info page.
     * Get the device id from the url and use it to find the associated device in the database
     *
     * @param Request $request
     * @param $device_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDevicePage(Request $request, $device_id)
    {
        $device = Device::findOrFail($device_id);
        return view('device.view', [
            'title' => $device->name,
            'device' => $device
        ]);
    }

    /**
     * Show the device update page.
     * Get the device id from the url and use it to fill in the form with current data
     *
     * @param $device_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdatePage($device_id)
    {
        $device = Device::findOrFail($device_id);
        return view('device.update', [
            'title' => 'Update ' . $device->name,
            'device' => $device
        ]);
    }

    /**
     * Handle a device update request POSTed from the device update page.
     * Validate the data and attempt to update the device.
     *
     * @param Request $request
     * @param $device_id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Show the delete page for a device
     *
     * @param $device_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDeletePage($device_id)
    {
        $device = Device::findOrFail($device_id);
        return view('device.delete', [
            'title' => 'Delete ' . $device->name,
            'device' => $device
        ]);
    }

    /**
     * Handle a device delete request POSTed from the device delete page
     *
     * @param $device_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postDeletePage($device_id)
    {
        $device = Device::findOrFail($device_id);
        $device->delete();
        return redirect('/devices');
    }

    /**
     * Show device messages in JSON
     *
     * @param $device_id
     * @return mixed
     */
    public function showMessages($device_id)
    {
        $device = Device::findorFail($device_id);
        return $device->messages;
    }

    /**
     * Get device data from the last 24 hours only.
     *
     * @param $device_id
     * @return mixed
     */
    public function getDeviceData($device_id){
        $device = Device::findorFail($device_id);
        $filtered = $device->messages->filter(function($value, $key){
            return $value->created_at->gt(Carbon::now()->subHours(24));
        })->values();
        $device->data = $filtered;
        return $device;
    }

    /**
     * Get the device type of a device (JSON)
     *
     * @param $device_id
     * @return mixed
     */
    public function getDeviceExpectedData($device_id){
        return Device::findorFail($device_id)->device_type;
    }
}














