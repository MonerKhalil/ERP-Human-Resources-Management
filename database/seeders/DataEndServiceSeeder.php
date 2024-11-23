<?php

namespace Database\Seeders;

use App\Models\DataEndService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataEndServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1 ; $i <= 10 ; $i++){
            DataEndService::create([
                "employee_id" => $i,
                "decision_id" => $i,
                "reason" => "military_service",
                "description" => "kmalsads".$i,
                "start_break_date" => now(),
                "end_break_date" => now(),
                "created_at" => now(),
            ]);
        }
    }
}
