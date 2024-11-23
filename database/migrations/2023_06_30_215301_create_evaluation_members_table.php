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
        Schema::create('evaluation_members', function (Blueprint $table) {
            $table->id();
            #Add Columns
            //from 1 --- 10
            $table->foreignId("evaluation_id")->constrained("employee_evaluations")->restrictOnDelete();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->tinyInteger("performance")->default(0);
            $table->tinyInteger("professionalism")->default(0);
            $table->tinyInteger("readiness_for_development")->default(0);
            $table->tinyInteger("collaboration")->default(0);
            $table->tinyInteger("commitment_and_responsibility")->default(0);
            $table->tinyInteger("innovation_and_creativity")->default(0);
            $table->tinyInteger("technical_skills")->default(0);
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
        Schema::dropIfExists('evaluation_members');
    }
};
