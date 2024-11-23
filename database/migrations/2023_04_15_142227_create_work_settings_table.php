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
        Schema::create('work_settings', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->string("name")->unique();
            $table->integer("count_days_work_in_weeks");
            $table->integer("count_hours_work_in_days");
            $table->string("days_leaves_in_weeks");
            $table->time("work_hours_from");
            $table->time("work_hours_to");
            $table->integer("late_enter_allowance_per_minute");
            $table->integer("early_out_allowance_per_minute");
            $table->float("salary_default");
            $table->integer("rate_deduction_from_salary");
            $table->integer("rate_deduction_attendance_dont_check_out");
            $table->enum("type_discount_minuteOrHour",["minute","hour"])->default("minute");
            $table->text("description")->nullable();
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
        Schema::dropIfExists('work_settings');
    }
};
