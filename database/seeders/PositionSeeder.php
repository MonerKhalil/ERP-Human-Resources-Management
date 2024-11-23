<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Contract;
use App\Models\Position;
use App\Models\PositionEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1 ; $i<=20;$i++){
            Position::create([
                "name" => "Position_".$i,
                "rate_salary" => $i,
                "rate_stimulus" => $i,
                "created_at" => now(),
            ]);
        }

        for ($i = 1 ; $i<=10;$i++){
            PositionEmployee::create([
                "employee_id" => $i,
                "position_id" => $i,
                "decision_id" => $i,
                "notes" => "xxxxxxxxx".$i,
                "created_at" => now(),
                "start_date" => now(),
                "end_date" => now(),
            ]);
        }

        for ($i = 1 ; $i<=10;$i++){
            Contract::create([
                "employee_id" => $i,
                "section_id" => $i,
                "contract_number" => $i,
                "contract_type" => "temporary",
                "salary" => 5*$i,
                "created_at" => now(),
                "contract_date" => now(),
                "contract_finish_date" => now(),
                "contract_direct_date" => now(),
            ]);
        }
    }
}
