<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Sections;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //super_admin
        Employee::create([
            "work_setting_id" => 1,
            "user_id" => 1,
            "section_id" => 1,
            "nationality" => 213,
            "first_name" => "anas",
            "last_name" => "anas",
            "father_name" => "ahmad",
            "mother_name" => "amal",
            "NP_registration" => "103410212121384",
            "birth_place" => "syria",
            "job_site" => "developer",
            "current_job" => "developer",
            "number_national" => "1234567",
            "number_file" => "1234567",
            "number_insurance" => "1234567",
            "number_self" => "1234567",
            "gender" => "male",
            "military_service" => "performer",
            "family_status" => "married",
            "number_child" => "3",
            "number_wives" => "1",
            "birth_date" => now(),
            "created_at" => now(),
            "count_administrative_leaves" => 14,
        ]);
        //employee
        Employee::create([
            "work_setting_id" => 2,
            "user_id" => 2,
            "section_id" => 1,
            "nationality" => 213,
            "first_name" => "moner",
            "last_name" => "moner",
            "father_name" => "mohammad",
            "mother_name" => "salma",
            "NP_registration" => "89876121",
            "birth_place" => "syria",
            "job_site" => "it",
            "current_job" => "it",
            "number_national" => "89876121",
            "number_file" => "89876121",
            "number_insurance" => "89876121",
            "number_self" => "89876121",
            "gender" => "male",
            "military_service" => "performer",
            "family_status" => "married",
            "number_child" => "3",
            "number_wives" => "1",
            "birth_date" => now(),
            "created_at" => now(),
            "count_administrative_leaves" => 14,
        ]);
        //hr
        Employee::create([
            "work_setting_id" => 1,
            "user_id" => 3,
            "section_id" => 1,
            "nationality" => 213,
            "first_name" => "amir",
            "last_name" => "amir",
            "father_name" => "ahmad",
            "mother_name" => "amal",
            "NP_registration" => "6656253",
            "birth_place" => "syria",
            "job_site" => "hr",
            "current_job" => "hr",
            "number_national" => "6656253",
            "number_file" => "6656253",
            "number_insurance" => "6656253",
            "number_self" => "6656253",
            "gender" => "male",
            "military_service" => "performer",
            "family_status" => "married",
            "number_child" => "3",
            "number_wives" => "1",
            "birth_date" => now(),
            "created_at" => now(),
            "count_administrative_leaves" => 14,
        ]);
        //diwan_manager
        Employee::create([
            "work_setting_id" => 1,
            "user_id" => 4,
            "section_id" => 3,
            "nationality" => 213,
            "first_name" => "hamza",
            "last_name" => "hamza",
            "father_name" => "osama",
            "mother_name" => "ward",
            "NP_registration" => "45633111",
            "birth_place" => "syria",
            "job_site" => "diwan_manager",
            "current_job" => "diwan_manager",
            "number_national" => "45633111",
            "number_file" => "45633111",
            "number_insurance" => "45633111",
            "number_self" => "45633111",
            "gender" => "male",
            "military_service" => "performer",
            "family_status" => "married",
            "number_child" => "3",
            "number_wives" => "1",
            "birth_date" => now(),
            "created_at" => now(),
            "count_administrative_leaves" => 14,
        ]);
        //legal_manager
        Employee::create([
            "work_setting_id" => 1,
            "user_id" => 5,
            "section_id" => 2,
            "nationality" => 213,
            "first_name" => "hamza",
            "last_name" => "hamza",
            "father_name" => "osama",
            "mother_name" => "ward",
            "NP_registration" => "3312145633111",
            "birth_place" => "syria",
            "job_site" => "legal_manager",
            "current_job" => "legal_manager",
            "number_national" => "3312145633111",
            "number_file" => "3312145633111",
            "number_insurance" => "3312145633111",
            "number_self" => "3312145633111",
            "gender" => "male",
            "military_service" => "performer",
            "family_status" => "married",
            "number_child" => "3",
            "number_wives" => "1",
            "birth_date" => now(),
            "created_at" => now(),
            "count_administrative_leaves" => 14,
        ]);

        //الذاتية
        Sections::query()->find(1)->update([
            "moderator_id" => 1,
        ]);
        //قسم الشؤون القانونية
        Sections::query()->find(2)->update([
            "moderator_id" => 5,
        ]);
        //قسم الديوان
        Sections::query()->find(3)->update([
            "moderator_id" => 4,
        ]);
        //قسم العلاقات العملاء
        Sections::query()->find(4)->update([
            "moderator_id" => 1,
        ]);
    }
}
