<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->foreignId("section_id")->constrained("sections")->restrictOnDelete();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->enum("contract_type", ["permanent", "temporary"]);
            $table->bigInteger("contract_number")->unsigned()->unique();
            $table->date("contract_date");
            $table->date("contract_finish_date");
            $table->date("contract_direct_date");
            $table->bigInteger("salary");
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
        Schema::dropIfExists('contracts');
    }
};
