<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DataGeneration extends Controller
{

    public function index(Device $device){
		$duration = 86400; // seconds (1 day = 86400 seconds)
		$interval = 30; // seconds
		$differential = 0.1; // units either side of current value
		$default_target = 15; // if data is not yet set
		$default_current = 15; // if data is not yet set
		$limit_upper = 25; // absolute maximum value
		$limit_lower = 0; // absolute minimum value
		$follow_leeway = 0.8; // distance from target allowed
		$target_modifiers = array( // target modifiers at 24h time
			'06:30:00' => 16,
			'09:00:00' => 8,
			'16:00:00' => 14,
			'20:00:00' => 18,
			'24:00:00' => 10
		);

		$device->setHidden([]);
		$device->messages; // appends messages to $device
		$device->device_type; // appends device_type to $device
		$device->last_message = $device->getLastMessageAttribute(); // appends last_message to $device

		$temp_target = (isset($device->last_message) ? $device->last_message->body['temp_target'] : $default_target); // get starting temperature
		$temp_current = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $default_current); // get starting temperature

		$new_temp_array = [];

		$starting_time = strtotime('now') - $duration;
		$target_time = strtotime('now');

		for($i=$starting_time;$i<$target_time;$i++){
			if(array_key_exists(date('H:i:s', $i), $target_modifiers)){
				$temp_target = $target_modifiers[date('H:i:s', $i)];
			}
			if($i % $interval == 0){
				$id = $i-$starting_time;
				$new_temp_min = ($limit_lower !== null && ($temp_current*10 - $differential*10) < $limit_lower*10 ? $limit_lower*10 : $temp_current*10 - $differential*10);
				$new_temp_max = ($limit_upper !== null && ($temp_current*10 + $differential*10) > $limit_upper*10 ? $limit_upper*10 : $temp_current*10 + $differential*10);
				$new_temp = mt_rand($new_temp_min*10, $new_temp_max*10)/100;
				$too_far = false;
				switch($new_temp){
					case ($new_temp < $temp_target-$follow_leeway):
						$new_temp = mt_rand($new_temp, $temp_target+$follow_leeway);
						$too_far = true;
						break;
					case ($new_temp > $temp_target+$follow_leeway):
						$new_temp = mt_rand($temp_target+$follow_leeway, $new_temp);
						$too_far = true;
						break;
				}

				$new_temp_array[] = array(
					'id' => $id,
					'device_id' => $device->id,
					'created_at' => date('Y-m-d H:i:s', $i),
					'created_atw' => date('H:i:s', $i),
					'too_far' => $too_far,
					'body' => array(
						'temp_target' => $temp_target,
						'temp_current' => $new_temp,
					)
				);

				$temp_current = $new_temp;

			}
		}
		$device->a = date('Y-m-d H:i:s');
		$device->data = $new_temp_array;
		return $device;
	}
}
