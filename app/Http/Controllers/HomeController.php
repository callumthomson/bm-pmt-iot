<?php

namespace App\Http\Controllers;

use App\Device;
use App\DeviceType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Apply authentication protection (user must be logged in)
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('devices');
//		$thermo = DeviceType::where('name', 'Heating System')->first();
//		$thermo = Device::where('type_id', $thermo->id)->first();
//		$thermo->last_message = $thermo->getLastMessageAttribute();
//		return view('home', compact($thermo));
    }
}
