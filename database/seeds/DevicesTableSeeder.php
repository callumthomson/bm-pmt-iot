<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->insert([
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'type_id' => 1,
                'name' => 'Kitchen Fridge',
                'token' => str_random(32),
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'type_id' => 2,
                'name' => 'Thermostat',
                'token' => str_random(32),
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'type_id' => 3,
                'name' => 'Gas Meter',
                'token' => str_random(32),
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'type_id' => 4,
                'name' => 'Water meter',
                'token' => str_random(32),
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'type_id' => 5,
                'name' => 'Electricity Meter',
                'token' => str_random(32),
            ],
        ]);
    }
}
