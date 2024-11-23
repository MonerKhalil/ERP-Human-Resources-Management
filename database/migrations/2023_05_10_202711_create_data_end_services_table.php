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
        Schema::create('data_end_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->foreignId("decision_id")->nullable()->constrained("decisions")->restrictOnDelete();
            $table->enum("reason",["disintegration","resignation","military_service","leaving_work","other"]);
            $table->string("reason_other")->nullable();
            $table->date("start_break_date")->nullable();
            $table->date("end_break_date")->nullable();
            $table->text("description")->nullable();
            $table->boolean("is_request_end_services")->default(false);
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
        Schema::dropIfExists('data_end_services');
    }
};
