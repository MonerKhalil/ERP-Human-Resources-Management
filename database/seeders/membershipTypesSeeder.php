<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\Membership_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class membershipTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0 ; $i<10;$i++){
            Membership_type::create([
                "name" => $i."test",
            ]);
        }

        for ($i = 1 ; $i<=10;$i++){
            Membership::create([
                "employee_id" => $i,
                "member_type_id" => $i,
                "number_membership" => $i,
                "branch" => $i,
                "created_at" => now(),
                "date_start" => now(),
                "date_end" => now(),
            ]);
        }
    }
}
