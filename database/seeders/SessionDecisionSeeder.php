<?php

namespace Database\Seeders;

use App\Models\SessionDecision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionDecisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1;$i<=20;$i++){
            SessionDecision::create([
                "moderator_id" => $i,
                "name" => "type".$i,
                "date_session" => now(),
                "file" => "akmsa".$i,
                "image" => "akmsa".$i,
                "description" => "akmsa".$i,
                "created_at" => now(),
            ]);
        }
    }
}
