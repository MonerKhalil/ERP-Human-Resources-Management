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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->foreignId("address_id")->constrained("addresses")->restrictOnDelete();
            $table->foreignId("employee_id")->constrained("employees")->cascadeOnDelete();
            $table->bigInteger("work_number")->unique();
            $table->bigInteger("private_number1")->nullable();
            $table->bigInteger("private_number2")->nullable();
            $table->string("email")->nullable();
            $table->string("address_details")->nullable();
            $table->enum("address_type",["house","clinic","office"]);
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
        Schema::dropIfExists('contacts');
    }
};
