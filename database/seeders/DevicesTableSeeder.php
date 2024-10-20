<?php

namespace Database\Seeder;
use App\Models\Devices;
use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    public function run()
    {
        Devices::insert([
            [
                'name' => 'Device 1',
                'type' => 'Sensor',
                'location' => 'Warehouse'
            ],
            [
                'name' => 'Device 2',
                'type' => 'Controller',
                'location' => 'Main Office'
            ],
            [
                'name' => 'Device 3',
                'type' => 'Gateway',
                'location' => 'Remote Site'
            ]
        ]);
    }
}