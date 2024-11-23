<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->string("name")->unique();
            $table->enum("type_effect_salary",["unpaid","paid","effect_salary"]);
            $table->integer("rate_effect_salary")->unsigned()->nullable();
            $table->enum("gender",["male","female","any"])->default("any");
            $table->integer("max_days_per_years")->default(0);
            $table->boolean("can_take_hours")->nullable();
            //check years services employee -> leave type -> true
            $table->integer("years_employee_services")->nullable();
            $table->boolean("leave_limited");
            $table->boolean("is_hourly")->default(false);
            $table->integer("max_hours_per_day")->nullable();
            //new columns ...
            #_تحديد عدد سنين الخدمة الي لزيادة في ايام الاساسية لهاي الاجازة
            $table->integer("number_years_services_increment_days")->nullable();
            $table->integer("count_days_increment_days")->nullable();
            $table->integer("count_available_in_service")->nullable();
            $table->boolean("is_active")->default(true);
            $table->foreignId("created_by")->nullable()->constrained("users")->restrictOnDelete();
            $table->foreignId("updated_by")->nullable()->constrained("users")->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_types');
    }
};
