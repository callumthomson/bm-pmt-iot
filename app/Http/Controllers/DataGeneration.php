<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DataGeneration extends Controller
{
    public function index(Device $device){
		// TODO find a way to generate realistic data for a device type

		$interval = 30; // seconds
		$differential = 2; // units either side of current value
		$target_modifiers = array(
			30 => 10
		); // at time 30 set target to 10

		$device->setHidden([]);
		$device->messages; // appends messages to $device
		$device->device_type; // appends device_type to $device
		$device->last_message = $device->getLastMessageAttribute(); // appends last_message to $device
		$temp_target = ($device->last_message = null ? 15 : $device->last_message->body['temp_target']); // get starting temperature
		$temp_current = ($device->last_message = null ? 15 : $device->last_message->body['temp_current']); // get starting temperature
		$new_temp_array = [];
		for($i=0;$i<100;$i++){
			$id = $i+1;
			$new_temp_min = $temp_current - $differential;
			$new_temp_max = $temp_current + $differential;
			$new_temp = rand($new_temp_min, $new_temp_max);
			$new_temp_array[] = array(
				'id' => $id,
				'device_id' => $device->id,
				'created_at' => date('Y-m-d H:i:s', strtotime('now') + ($interval*$i)),
				'body' => array(
					'temp_target' => $temp_target,
					'temp_current' => $new_temp
				)
			);

			$temp_current = $new_temp;
		}
		$device->a = date('Y-m-d H:i:s');
		$device->data = $new_temp_array;
		return $device;
	}
}
