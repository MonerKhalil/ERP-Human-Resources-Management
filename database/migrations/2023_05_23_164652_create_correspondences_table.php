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
        Schema::create('correspondences', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();///createrr if internal
            $table->bigInteger('number_internal')->nullable()->unique();
            $table->bigInteger('number_external')->nullable()->unique();
            $table->enum('type',['internal','external']);
            $table->date("date");
            $table->string('subject');
            $table->text('summary');
            $table->text("path_file")->nullable();
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
        Schema::dropIfExists('correspondences');
    }
};
