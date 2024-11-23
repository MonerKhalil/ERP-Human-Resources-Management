<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Language_skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0 ; $i<10;$i++){
            Language::create([
                "name" => $i."test",
            ]);
        }

        for ($i = 1 ; $i<=10;$i++){
            Language_skill::create([
                "employee_id" => $i,
                "language_id" => $i,
                "read" => "Beginner",
                "write" => "Intermediate",
                "created_at" => now(),
            ]);
        }
    }
}
