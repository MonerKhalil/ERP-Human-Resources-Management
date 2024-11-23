<?php

namespace Database\Seeders;

use App\Models\WorkSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class WorkSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkSetting::create([
            "name" => "general",
            "count_days_work_in_weeks" => 5,
            "count_hours_work_in_days" => 8,
            "days_leaves_in_weeks" => "Friday,Saturday",
            "work_hours_from" => Carbon::create(0,0,0,9)->format("G:i:s"),
            "work_hours_to" => Carbon::create(0,0,0,17)->format("G:i:s"),
            "late_enter_allowance_per_minute" => 3000 ,
            "early_out_allowance_per_minute" => 3000 ,
            "salary_default" => 1000,
            "rate_deduction_from_salary" => 15,
            "type_discount_minuteOrHour" => "minute",
            "rate_deduction_attendance_dont_check_out" => 1,
        ]);
        WorkSetting::create([
            "name" => "employee_shift",
            "count_days_work_in_weeks" => 5,
            "count_hours_work_in_days" => 8,
            "days_leaves_in_weeks" => "Friday,Saturday",
            "work_hours_from" => Carbon::create(0,0,0,9)->format("G:i:s"),
            "work_hours_to" => Carbon::create(0,0,0,17)->format("G:i:s"),
            "late_enter_allowance_per_minute" => 30 ,
            "early_out_allowance_per_minute" => 30 ,
            "salary_default" => 1000,
            "rate_deduction_from_salary" => 15,
            "type_discount_minuteOrHour" => "minute",
            "rate_deduction_attendance_dont_check_out" => 1,
        ]);
    }
}
