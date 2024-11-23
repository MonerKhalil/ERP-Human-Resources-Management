<?php

namespace Database\Seeders;

use App\Models\TypeDecision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeDecisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1;$i<=20;$i++){
            TypeDecision::create([
                "name" => "type".$i,
                "created_at" => now(),
            ]);
        }
    }
}
