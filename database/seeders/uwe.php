<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class uwe extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('things_datas')->insert([
            [
                'things_id' => 1, // Sesuaikan dengan things_id yang ada
                'value' => 24.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'things_id' => 1, // Sesuaikan dengan things_id yang ada
                'value' => 54.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'things_id' => 2, // Sesuaikan dengan things_id yang ada
                'value' => 54.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'things_id' => 2, // Sesuaikan dengan things_id yang ada
                'value' => 70.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
