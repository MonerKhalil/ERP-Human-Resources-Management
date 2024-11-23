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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->float("total_salary");
            $table->float("default_salary");
            $table->integer("overtime_minute")->default(0);
            $table->float("overtime_value")->default(0);
            $table->float("bonuses_decision")->default(0);//المكافئات
            $table->float("penalties_decision")->default(0);//العقوبات
            $table->integer("absence_days")->default(0);//ايام الغياب الغير مبرر
            $table->float("absence_days_value")->default(0); //قيمة ايام الغياب الغير مبرر
            $table->integer("count_leaves_unpaid")->default(0);
            $table->float("leaves_unpaid_value")->default(0);
            $table->integer("count_leaves_effect_salary")->default(0);
            $table->float("leaves_effect_salary_value")->default(0);
            $table->float("position_employee_value")->default(0);
            $table->float("conferences_employee_value")->default(0);
            $table->float("education_value")->default(0);
            $table->integer("minutes_late_entry")->default(0);
            $table->float("minutes_late_entry_value")->default(0);
            $table->integer("minutes_early_exit")->default(0);
            $table->float("minutes_early_exit_value")->default(0);
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
        Schema::dropIfExists('payrolls');
    }
};
