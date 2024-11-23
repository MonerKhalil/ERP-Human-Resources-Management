<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Education_data;
use App\Models\Education_level;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Education_level::create([
            "name" => " بكلوريوس",
            "created_at" => now(),
        ]);
        Education_level::create([
            "name" => " دكتورا",
            "created_at" => now(),
        ]);
        Education_level::create([
            "name" => " دبلوم",
            "created_at" => now(),
        ]);
        Education_level::create([
            "name" => " ماجستير",
            "created_at" => now(),
        ]);
        Education_level::create([
            "name" => " شهادة تاسع",
            "created_at" => now(),
        ]);
        Education_level::create([
            "name" => " شهادة بكلوريا",
            "created_at" => now(),
        ]);
        Education_level::create([
            "name" => " معهد متوسط",
            "created_at" => now(),
        ]);


        Education_data::create([
            "employee_id" => 1,
            "id_ed_lev" => 2,
            "college_name" => "جامعة دمشق",
            "amount_impact_salary" => 40,
            "created_at" => now(),
            "grant_date" => now(),
        ]);
        Education_data::create([
            "employee_id" => 2,
            "id_ed_lev" => 1,
            "college_name" => "جامعة حلب",
            "amount_impact_salary" => 30,
            "created_at" => now(),
            "grant_date" => now(),
        ]);
        Education_data::create([
            "employee_id" => 3,
            "id_ed_lev" => 3,
            "college_name" => "جامعة البعث",
            "amount_impact_salary" => 20,
            "created_at" => now(),
            "grant_date" => now(),
        ]);

        Education_data::create([
            "employee_id" => 4,
            "id_ed_lev" => 6,
            "college_name" => "جامعة البعث",
            "amount_impact_salary" => 20,
            "created_at" => now(),
            "grant_date" => now(),
        ]);

        Education_data::create([
            "employee_id" => 5,
            "id_ed_lev" => 5,
            "college_name" => "جامعة تشريين",
            "amount_impact_salary" => 10,
            "created_at" => now(),
            "grant_date" => now(),
        ]);
        $this->contact();
    }

    private function contact(){
        Contact::create([
            "address_id"=>3459,
            "employee_id"=>1,
            "work_number"=>886214,
            "address_details"=>"دمشق ,دوار كفر سوسة",
            "private_number1"=> "0945675744",
            "private_number2"=>"0945675745 ",
            "address_type"=>"house",
            "email"=>"hamz3.zy2017@gmail.com",
        ]);
        Contact::create([
            "address_id"=>3459,
            "employee_id"=>2,
            "work_number"=>886244,
            "address_details"=>"دمشق ,الميدان ,نهر عيشة",
            "private_number1"=> "0945675742",
            "private_number2"=>"0945675744",
            "address_type"=>"office",
            "email"=>"hamz9.zy2017@gmail.com",
        ]);

        Contact::create([
            "address_id"=>3459,
            "employee_id"=>3,
            "work_number"=>886290,
            "address_details"=>"دمشق ,مساكن برزة حامييش ",
            "private_number1"=> "0945675787",
            "private_number2"=>"0945675798",
            "address_type"=>"house",
            "email"=>"hamz3.zy34ل@gmail.com",
        ]);
        Contact::create([
            "address_id"=>3459,
            "employee_id"=>4,
            "work_number"=>886250,
            "address_details"=>"دمشق ,المالكي ",
            "private_number1"=> "0945345787",
            "private_number2"=>"0945625798",
            "address_type"=>"house",
            "email"=>"hr.zy34ل@gmail.com",
        ]);
        Contact::create([
            "address_id"=>3459,
            "employee_id"=>5,
            "work_number"=>886190,
            "address_details"=>"دمشق ,المزة حامييش ",
            "private_number1"=> "0945475787",
            "private_number2"=>"0945565798",
            "address_type"=>"house",
            "email"=>"mohamad.zy34ل@gmail.com",
        ]);
    }
}
