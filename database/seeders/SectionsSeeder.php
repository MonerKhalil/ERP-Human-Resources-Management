<?php

namespace Database\Seeders;

use App\Models\Sections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sections::create([
            "address_id" =>3459 ,
            "name" => "قسم الذاتية",
            "details" => "يهتم بتخزين ومعالجة كافة معلومات الموظف ",
            "created_at" => now(),
        ]);
        Sections::create([
            "address_id" => 3459 ,
            "name" => "قسم الشؤون القانونية",
            "details" => "يهتم بالأمور القانونية في المؤسسة",
            "created_at" => now(),
        ]);
        Sections::create([
            "address_id" => 3459 ,
            "name" => "قسم الديوان ",
            "details" => "يهتم بمعالجة المراسلات ومتابعة حركاتها ",
            "created_at" => now(),
        ]);
        Sections::create([
            "address_id" => 3459 ,
            "name" => "قسم العلاقات العملاء ",
            "details" => "يهتم بمناقشة مشاكل العملاء وخدمتهم",
            "created_at" => now(),
        ]);
    }
}
