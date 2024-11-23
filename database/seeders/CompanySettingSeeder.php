<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanySetting::create([
            "name" => "HR-ERP",
            "created_at_company" => now(),
            "count_administrative_leaves" => 14,
            "count_years_services_employees" => 5,
            "add_leaves_years_services_employees" => 10,
        ]);
    }
}
