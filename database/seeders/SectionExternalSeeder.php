<?php

namespace Database\Seeders;

use App\Models\SectionExternal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionExternalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SectionExternal::create([
            "address_id" =>3459 ,
            "name" => " مطار دمشق الدولي",
            "address_details" => "ريف دمشق منطقة الغزلانية",
            "email"=>"hamza.zy2017@gmail.com" ,
            "fax"=>"syr@x.fax",
            "phone"=>"0945675741" ,
            "created_at" => now(),
        ]);
        SectionExternal::create([
            "address_id" =>3460 ,
            "name" => " مطار حلب الدولي",
            "address_details" => " شرق حلب منطقة الميدان",
            "email"=>"moner.kh@gmail.com" ,
            "fax"=>"syr11@x.fax " ,
            "phone"=>"0932233875" ,
            "created_at" => now(),
        ]);

        SectionExternal::create([
            "address_id" =>3459 ,
            "name" => " الهيئة الناظمة للأتصالات",
            "address_details" => "دمشق, المزة, فيلات غربية",
            "email"=>"amer.helo@gmail.com" ,
            "fax"=>"syr22@x.fax " ,
            "phone"=>"0932233872" ,
            "created_at" => now(),
        ]);

        SectionExternal::create([
            "address_id" =>3459 ,
            "name" => " وزارة النقل",
            "address_details" => "دمشق, اتستراد درعا الدولي ,الميدان نهر عيشة",
            "email"=>"anas.helo@gmail.com" ,
            "fax"=>"syr22@x.fax " ,
            "phone"=>"0932233873" ,
            "created_at" => now(),
        ]);
    }
}
