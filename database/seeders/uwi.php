<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Things;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class uwi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dapatkan semua devices yang ada di tabel devices
        DB::table('things')->insert([
            [
                'things_type' => 'Temperature Sensor',
                'status' => true,
                'devices_id' => 1, // Sesuaikan dengan devices_id yang ada
                'value_set' => 25.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'things_type' => 'sensor',
                'status' => true,
                'devices_id' => 1, // Sesuaikan dengan devices_id yang ada
                'value_set' => 25.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'things_type' => 'Light Bulb',
                'status' => false,
                'devices_id' => 2, // Sesuaikan dengan devices_id yang ada
                'value_set' => 0.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
