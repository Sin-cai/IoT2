<?php

namespace Database\Seeders;

use App\Models\User;
use UsersTableSeeder;
use App\Models\Things;
use App\Models\Devices;
use Illuminate\Database\Seeder;
use Database\Seeder\DevicesTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class yesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call([
            owo::class,
            uwu::class,
            uwi::class,
            uwe::class
        ]);
    }
}
