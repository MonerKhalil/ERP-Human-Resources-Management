<?php

namespace Database\Seeders;

use App\Models\Decision;
use App\Models\EmployeeDecision;
use Illuminate\Database\Seeder;

class DecisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1;$i<=20;$i++){
            Decision::create([
                "type_decision_id" => $i,
                "session_decision_id" => $i,
                "number" => $i,
                "effect_salary" => "decrement",
                "value" => $i,
                "rate" => $i,
                "date" => now(),
                "content" => "akmsa".$i,
                "image" => "akmsa".$i,
                "end_date_decision" => now(),
                "created_at" => now(),
            ]);
        }

        for ($i = 1 ; $i<=10;$i++){
            EmployeeDecision::create([
                "employee_id" => $i,
                "decision_id" => $i,
                "created_at" => now(),
            ]);
        }
    }
}
