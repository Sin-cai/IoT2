<?php
use Illuminate\Database\Seeder;
use App\Models\Things;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class uwo extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@example.com',
                'password' => Hash::make('password'),
            ]
        ]);
    }
}
