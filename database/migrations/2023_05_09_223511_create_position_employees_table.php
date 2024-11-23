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
        Schema::create('position_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId("position_id")->constrained("positions")->restrictOnDelete();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->foreignId("decision_id")->constrained("decisions")->restrictOnDelete();
            $table->date("start_date");
            $table->date("end_date");
            $table->text("notes");
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
        Schema::dropIfExists('position_employees');
    }
};
