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
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Heating System',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Gas Meter',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Water Meter',
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Electricity Meter',
            ],
        ]);
    }
}
