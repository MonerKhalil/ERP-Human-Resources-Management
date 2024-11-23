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
        Schema::create('section_externals', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->string("name")->unique();
            $table->foreignId("address_id")->constrained("addresses")->restrictOnDelete();
            $table->string("address_details");
            $table->string("email")->nullable();
            $table->string("fax")->nullable();
            $table->string("phone")->nullable();
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
        Schema::dropIfExists('section_externals');
    }
};
