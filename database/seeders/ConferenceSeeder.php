<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\ConferenceEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1;$i<=20;$i++){
            Conference::create([
                "address_id" => $i,
                "name" => "xxxx".$i,
                "name_party" => "xxxx_name_party_".$i,
                "start_date" => now(),
                "end_date" => now(),
                "rate_effect_salary" => $i,
                "address_details" => "kmaskmaskm".$i,
                "type" => "conference",
                "created_at" => now(),
            ]);
        }
        for ($i = 1 ; $i<=10;$i++){
            ConferenceEmployee::create([
                "employee_id" => $i,
                "conference_id" => $i,
                "created_at" => now(),
            ]);
        }
    }
}
