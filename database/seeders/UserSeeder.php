<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0;$i<1000;$i++){
            User::create([
                "name" => 'mmm'.$i,
                "email" => 'mmm'.$i,
                "password" => 'mmm'.$i,
                "created_at" => now(),
            ]);
        }
    }
}
