<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DataGeneration extends Controller
{

	public $defaults = [
		'duration' => 86400, // seconds (1 day = 86400 seconds)
		'interval' => 30, // seconds
		'differential' => 1, // units either side of current value
		'differential_modulation' => null, // varies the differential after every turn [min_differential, max_differential]
		'default_target' => 15, // if data is not yet set
		'default_current' => 15, // if data is not yet set
		'limit_upper' => 25, // absolute maximum value
		'limit_lower' => 0, // absolute minimum value
		'follow_leeway' => 0.5, // distance from target allowed
		'follow_target' => true, // whether the current value should attempt for follow target value
		'modifiers' => [ // target modifiers in 24h time
			'06:30:00' => 16,
			'09:00:00' => 8,
			'16:00:00' => 14,
			'20:00:00' => 18,
			'00:00:00' => 10
		],
		'differential_timing' => [
			'05:00:00' => 0.2,
			'06:30:00' => 0.8,
			'09:00:00' => 0.2,
			'16:00:00' => 1.0,
			'20:00:00' => 1.5,
			'00:00:00' => 1.0,
		]
	];

	/**
	 * Routes the requested device by device type
	 * @param Device $device
	 * @return Device
	 */
    public function index(Device $device){
		$fluctuating = [1,2];
		$increasing = [3,4,5];

		$device->setHidden([]);
		$device->messages; // appends messages to $device
		$device->device_type; // appends device_type to $device
		$device->last_message = $device->getLastMessageAttribute(); // appends last_message to $device

		if(in_array($device->type_id, $fluctuating)){
			return $this->fluctuating($device);
		}
		if(in_array($device->type_id, $increasing)){
			return $this->increasing($device);
		}

    }

	/**
	 * Generates data for fluctuating device types
	 * @param Device $device
	 * @param array $settings
	 * @return Device
	 */
	public function fluctuating(Device $device, $settings = []){
		$settings = array_merge($this->defaults, $settings);

		$temp_target = (isset($device->last_message) ? $device->last_message->body['temp_target'] : $settings['default_target']); // get starting temperature
		$temp_current = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $settings['default_current']); // get starting temperature

		$new_array = [];

		$starting_time = strtotime('now') - $settings['duration'];
		$target_time = strtotime('now');

		for($i=$starting_time;$i<$target_time;$i++){
			if(array_key_exists(date('H:i:s', $i), $settings['modifiers'])){
				$temp_target = $settings['modifiers'][date('H:i:s', $i)];
			}
			if($i % $settings['interval'] == 0){
				$id = $i-$starting_time;
				$new_temp_min = ($settings['limit_lower'] !== null && ($temp_current*10 - $settings['differential']*10) < $settings['limit_lower']*10 ? $settings['limit_lower']*10 : $temp_current*10 - $settings['differential']*10);
				$new_temp_max = ($settings['limit_upper'] !== null && ($temp_current*10 + $settings['differential']*10) > $settings['limit_upper']*10 ? $settings['limit_upper']*10 : $temp_current*10 + $settings['differential']*10);
				$new_temp = mt_rand($new_temp_min*10, $new_temp_max*10)/100;
				if($settings['follow_target']){
					switch($new_temp){
						case ($new_temp < $temp_target-$settings['follow_leeway']):
							$new_temp = mt_rand($new_temp, $temp_target+$settings['follow_leeway']);
							break;
						case ($new_temp > $temp_target+$settings['follow_leeway']):
							$new_temp = mt_rand($temp_target+$settings['follow_leeway'], $new_temp);
							break;
					}
				}

				$new_array[] = array(
					'id' => $id,
					'device_id' => $device->id,
					'created_at' => date('Y-m-d H:i:s', $i),
					'body' => array(
						'temp_target' => $temp_target,
						'temp_current' => $new_temp,
					)
				);

				$temp_current = $new_temp;
			}
		}
		$device->data = $new_array;
		return $device;
	}

	/**
	 * Generates data for increasing device types
	 * @param Device $device
	 * @param array $settings
	 * @return Device
	 */
	public function increasing(Device $device, $settings = []){
		$settings = array_merge($this->defaults, $settings);

		$settings['duration'] = 86400*2;
		$settings['differential'] = 0.2;
		$settings['default_current'] = 1; // if data is not yet set
		$settings['differential_timing'] = [
			'05:00:00' => 0.2,
			'06:30:00' => 0.8,
			'09:00:00' => 0.2,
			'16:00:00' => 1.0,
			'20:00:00' => 1.5,
			'00:00:00' => 1.0,
		];

		$current = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $settings['default_current']); // get starting temperature

		$new_array = [];

		$starting_time = strtotime('now') - $settings['duration'];
		$target_time = strtotime('now');

		for($i=$starting_time;$i<$target_time;$i++){
			if(array_key_exists(date('H:i:s', $i), $settings['differential_timing'])){
				$settings['differential'] = $settings['differential_timing'][date('H:i:s', $i)];
			}
			if($i % $settings['interval'] == 0){
				$id = $i-$starting_time;
				$new_usage = mt_rand($current, $current + $settings['differential']);
				$new_array[] = array(
					'id' => $id,
					'device_id' => $device->id,
					'created_at' => date('Y-m-d H:i:s', $i),
					'body' => array(
						'usage' => $new_usage,
					)
				);

				$current = $new_usage;
			}
		}
		$device->data = $new_array;
		return $device;
	}
}
