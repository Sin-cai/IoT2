<?php

namespace Database\Seeders;

use App\Models\Devices;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class uwu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
         DB::table('devices')->insert([
            [
                'name' => 'Device 1',
                'device_type' => 'Sensor',
                'device_UID' => 'ABC123',
                'user_id' => 1, // Ganti dengan user_id yang ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Device 2',
                'device_type' => 'Actuator',
                'device_UID' => 'XYZ456',
                'user_id' => 1, // Ganti dengan user_id yang ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
