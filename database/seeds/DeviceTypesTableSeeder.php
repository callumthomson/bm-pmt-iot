<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DeviceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('device_types')->insert([
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Fridge',
                'expected_data' => '[{"id": "temp_target","display": "Target Temperature","unit": "&deg;C"},{"id": "temp_current","display": "Current Temperature","unit": "&deg;C"}]',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Heating System',
                'expected_data' => '[{"id": "temp_target","display": "Target Temperature","unit": "&deg;C"},{"id": "temp_current","display": "Current Temperature","unit": "&deg;C"}]',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Gas Meter',
                'expected_data' => '[{"id": "usage","display": "Usage","unit": "m<sup>3</sup>"}]',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Water Meter',
                'expected_data' => '[{"id": "usage","display": "Usage","unit": "l"}]',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Electricity Meter',
                'expected_data' => '[{"id": "usage","display": "Usage","unit": "kWh"}]',
            ],
        ]);
    }
}
