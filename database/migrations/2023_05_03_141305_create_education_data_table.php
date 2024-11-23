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
        Schema::create('education_data', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->foreignId("employee_id")->constrained("employees")->cascadeOnDelete();
            $table->foreignId("id_ed_lev")->constrained("education_levels")->cascadeOnDelete();
            $table->date("grant_date");
            $table->string("college_name");
            $table->integer("amount_impact_salary")->unsigned();
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
        Schema::dropIfExists('education_datas');
    }
};
