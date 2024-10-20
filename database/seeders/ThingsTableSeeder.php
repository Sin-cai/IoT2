<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Things;


class ThingsTableSeeder extends Seeder
{
    public function run()
    {

        Things::insert([
            [
                'things_type' => 'Temperature Sensor',
                'value1' => '25°C',
                'value2' => 'Operational',
                'device_id' => 1, // Asumsi device_id ini terhubung ke device pertama
            ],
            [
                'things_type' => 'Humidity Sensor',
                'value1' => '60%',
                'value2' => 'Operational',
                'device_id' => 2, // Asumsi device_id ini terhubung ke device kedua
            ],
            [
                'things_type' => 'Pressure Sensor',
                'value1' => '101.3 kPa',
                'value2' => 'Operational',
                'device_id' => 3, // Asumsi device_id ini terhubung ke device ketiga
            ]
        ]);
    }
}
