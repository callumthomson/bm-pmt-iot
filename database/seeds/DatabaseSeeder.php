<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DeviceTypesTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
    }
}
