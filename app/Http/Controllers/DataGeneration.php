<?php

namespace App\Http\Controllers;

use App\Device;
use App\Message;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataGeneration extends Controller
{

	public $defaults = [
		'save_to_db' => false, // Save to database [true] or output to json [false]
		'duration' => 86400, // seconds (1 day = 86400 seconds)
		'interval' => 30, // seconds
		'differential' => 1, // units either side of current value
		'differential_modulation' => null, // varies the differential after every turn [min_differential, max_differential]
		'default_id' => 1, // if data is not yet set
		'default_target' => 15, // if data is not yet set
		'default_current' => 15, // if data is not yet set
		'limit_upper' => 25, // absolute maximum value
		'limit_lower' => 0, // absolute minimum value
		'follow_leeway' => 0.5, // distance from target allowed
		'follow_target' => true, // whether the current value should attempt for follow target value
		'modifiers' => [ // target modifiers in 24h time, must be <= to limits
			'06:30' => 16,
			'09:00' => 8,
			'16:00' => 14,
			'20:00' => 18,
			'00:00' => 10,
			'08:00' => 25
		],
		'differential_timing' => [ // differential modifier in 24h time for increasing device types
			'05:00' => 0.2,
			'06:30' => 0.8,
			'09:00' => 0.2,
			'16:00' => 1.0,
			'20:00' => 1.5,
			'00:00' => 1.0,
		],
		'datetime_string' => ''
	];

	/**
	 * Routes the requested device by device type
	 * @param Device $device
	 * @return Device
	 */
    public function index(Device $device, $single=false){
		$this->defaults['save_to_db'] = request()->get('save_to_db');
		$this->defaults['datetime_string'] = Carbon::now()->timezone('Europe/London')->toDateTimeString();
		$this->defaults['datetime_stamp'] = Carbon::parse(Carbon::now()->timezone('Europe/London'))->timestamp;
		$this->defaults['single'] = $single;

		$fluctuating = [1,2];
		$increasing = [3,4,5];
		$device->messages; // appends messages to $device
		$device->device_type; // appends device_type to $device
		$device->last_message = $device->getLastMessageAttribute(); // appends last_message to $device



//		if($single){
//			if(in_array($device->type_id, $fluctuating)){
//				return $this->fluctuating_single($device);
//			}
//			if(in_array($device->type_id, $increasing)){
//				return $this->increasing_single($device);
//			}
//		} else {
			if(in_array($device->type_id, $fluctuating)){
				return $this->fluctuating($device);
			}
			if(in_array($device->type_id, $increasing)){
				return $this->increasing($device);
			}
//		}

    }
    public function single(Device $device){
		$this->index($device, true);
	}

    public function package($id, $device, $body, $timestamp=null){
		if(is_null($timestamp)){
			$timestamp = Carbon::parse(Carbon::now()->timezone('Europe/London'))->timestamp;
		}
		$data = [
			'id' => $id,
			'device_id' => $device->id,
			'created_at' => date('Y-m-d H:i:s', $timestamp),
			'body' => $body
		];

		if($this->defaults['save_to_db']){
			$device = Device::where('token', '=', $device->token)
				->first();
			$message = new Message([
				'created_at' => $data['created_at'],
				'body' => json_encode($body)
			]);
			$device->messages()->save($message);
		}

		return $data;
	}

	/**
	 * Generates data for fluctuating device types
	 * @param Device $device
	 * @param array $settings
	 * @return Device
	 */
	public function fluctuating(Device $device, $settings = [])
	{
		$settings = array_merge($this->defaults, $settings);

		$temp_target = (isset($device->last_message) ? $device->last_message->body['temp_target'] : $settings['default_target']); // get starting temperature
		$temp_current = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $settings['default_current']); // get starting temperature
//		return $temp_current . ' ' . $temp_target;
		$new_array = [];

		$starting_time = $settings['datetime_stamp'] - $settings['duration'];
		$target_time = $settings['datetime_stamp'];

		for ($i = $starting_time; $i < $target_time; $i++) {
			if (array_key_exists(date('H:i', $i), $settings['modifiers'])) {
				$temp_target = $settings['modifiers'][date('H:i', $i)];
			}
			if ($i % $settings['interval'] == 0) {
				$id = $i - $starting_time;
				$new_temp_min = ($settings['limit_lower'] !== null && ($temp_current * 10 - $settings['differential'] * 10) < $settings['limit_lower'] * 10 ? $settings['limit_lower'] * 10 : $temp_current * 10 - $settings['differential'] * 10);
				$new_temp_max = ($settings['limit_upper'] !== null && ($temp_current * 10 + $settings['differential'] * 10) > $settings['limit_upper'] * 10 ? $settings['limit_upper'] * 10 : $temp_current * 10 + $settings['differential'] * 10);
//
				$new_temp = mt_rand($new_temp_min * 10, $new_temp_max * 10) / 100;
				if ($settings['follow_target']) {
					switch ($new_temp) {
						case ($new_temp < $temp_target - $settings['follow_leeway']):
							$new_temp = mt_rand($new_temp, $temp_target + $settings['follow_leeway']);
							break;
						case ($new_temp > $temp_target + $settings['follow_leeway']):
							$new_temp = mt_rand($temp_target + $settings['follow_leeway'], $new_temp);
							break;
					}
				}

				$new_array[] = $this->package($id, $device, ['temp_target' => $temp_target, 'temp_current' => $new_temp], $i);


				$temp_current = $new_temp;
			}
		}
		$device->data = $new_array;
		return $device;
	}

	public function fluctuating_single(Device $device, $settings = []){
		$settings = array_merge($this->defaults, $settings);
		$temp_target = (isset($device->last_message) ? $device->last_message->body['temp_target'] : $settings['default_target']); // get starting temperature
		$temp_current = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $settings['default_current']); // get starting temperature
		$new_array = [];
		$time = date('H:i');
		if (array_key_exists($time, $settings['modifiers'])) {
			$temp_target = $settings['modifiers'][$time];
		}

		$id = (isset($device->last_message) ? $device->last_message->id +1 : 1);
		$new_temp_min = ($settings['limit_lower'] !== null && ($temp_current * 10 - $settings['differential'] * 10) < $settings['limit_lower'] * 10 ? $settings['limit_lower'] * 10 : $temp_current * 10 - $settings['differential'] * 10);
		$new_temp_max = ($settings['limit_upper'] !== null && ($temp_current * 10 + $settings['differential'] * 10) > $settings['limit_upper'] * 10 ? $settings['limit_upper'] * 10 : $temp_current * 10 + $settings['differential'] * 10);
		$new_temp = mt_rand($new_temp_min * 10, $new_temp_max * 10) / 100;
		if ($settings['follow_target']) {
			switch ($new_temp) {
				case ($new_temp < $temp_target - $settings['follow_leeway']):
					$new_temp = mt_rand($new_temp, $temp_target + $settings['follow_leeway']);
					break;
				case ($new_temp > $temp_target + $settings['follow_leeway']):
					$new_temp = mt_rand($temp_target + $settings['follow_leeway'], $new_temp);
					break;
			}
		}

		$new_array[] = $this->package($id, $device, ['temp_target' => $temp_target, 'temp_current' => $new_temp]);

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
//		return $settings;
		$settings['duration'] = 21600;
		$settings['differential'] = 0.1;
		$settings['default_current'] = 0; // if data is not yet set
		$settings['differential_timing'] = [
			'05:00' => 0.2,
			'06:30' => 0.8,
			'09:00' => 0.2,
			'14:00' => 1.1,
			'20:00' => 1.5,
			'00:00' => 1.0,
		];

		$new_usage = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $settings['default_current']); // get starting temperature
		$last_id = (isset($device->last_message) ? $device->last_message->id : $settings['default_id']); // get starting temperature

		$new_array = [];

		$starting_time = $settings['datetime_stamp'] - $settings['duration'];
		$target_time = $settings['datetime_stamp'];

		for($i=$starting_time;$i<$target_time;$i++){
			if(array_key_exists(date('H:i', $i), $settings['differential_timing'])){
				$settings['differential'] = $settings['differential_timing'][date('H:i', $i)];
			}
			if($i % $settings['interval'] == 0){
				$id = $last_id;
				$new_usage = ($new_usage*100 + mt_rand(0, ($settings['differential'])*100))/100;
				$new_array[] = $this->package($id, $device, ['usage' => $new_usage,], $i);
				$last_id++;
				if($settings['single']){
					$device->data = $new_array;
					return $device;
				}
			}
		}
		$device->data = $new_array;
		return $device;
	}
	
	public function increasing_single(Device $device, $settings = []){
		$settings = array_merge($this->defaults, $settings);
//		return $settings['datetime_stamp'];
		$settings['duration'] = 21600;
		$settings['differential'] = 0.1;
		$settings['default_current'] = 0; // if data is not yet set
		$settings['differential_timing'] = [
			'05:00' => 0.2,
			'06:30' => 0.8,
			'09:00' => 0.2,
			'14:00' => 1.1,
			'20:00' => 1.5,
			'00:00' => 1.0,
		];

		$new_usage = (isset($device->last_message) ? $device->last_message->body['temp_current'] : $settings['default_current']); // get starting temperature
		$last_id = (isset($device->last_message) ? $device->last_message->id : $settings['default_id']); // get starting temperature

		$new_array = [];

		if(array_key_exists(date('H:i', $settings['datetime_stamp']), $settings['differential_timing'])){
			$settings['differential'] = $settings['differential_timing'][date('H:i', $settings['datetime_stamp'])];
		}
		$id = $last_id;
		$new_usage = ($new_usage*100 + mt_rand(0, ($settings['differential'])*100))/100;
		$new_array[] = $this->package($id, $device, ['usage' => $new_usage,], $settings['datetime_stamp']);


		$device->data = $new_array;
		return $device;
	}
}
