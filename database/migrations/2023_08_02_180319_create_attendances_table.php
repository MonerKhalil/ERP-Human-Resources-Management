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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->time("check_in")->nullable();
            $table->time("check_out")->nullable();
            $table->integer("hours_work")->nullable();
            $table->integer("hours_work_per_minute")->nullable();
            $table->integer("late_entry_per_minute")->default(0);
            $table->integer("early_exit_per_minute")->default(0);
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
        Schema::dropIfExists('attendances');
    }
};
