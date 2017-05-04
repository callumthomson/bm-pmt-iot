<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fridge
        DB::table('messages')->insert([
            'device_id' => '1',
            'created_at' => Carbon::now()->subSeconds(30),
            'body' => '{"temp_target": 4,"temp_current": 3}'
        ]);
        DB::table('messages')->insert([
            'device_id' => '1',
            'created_at' => Carbon::now(),
            'body' => '{"temp_target": 4,"temp_current": 4}'
        ]);



        // Thermostat
        DB::table('messages')->insert([
            'device_id' => '2',
            'created_at' => Carbon::now()->subSeconds(30),
            'body' => '{"temp_target": 21,"temp_current": 18}'
        ]);
        DB::table('messages')->insert([
            'device_id' => '2',
            'created_at' => Carbon::now(),
            'body' => '{"temp_target": 21,"temp_current": 21}'
        ]);
    }
}
