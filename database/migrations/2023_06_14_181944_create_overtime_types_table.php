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
        Schema::create('overtime_types', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->string("name");
            $table->integer("max_rate_salary")->nullable();
            $table->integer("min_hours_in_days")->nullable();
            $table->bigInteger("salary_in_hours");
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
        Schema::dropIfExists('overtime_types');
    }
};
