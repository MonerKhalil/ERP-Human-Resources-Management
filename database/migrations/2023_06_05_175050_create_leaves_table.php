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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->foreignId("leave_type_id")->constrained("leave_types")->restrictOnDelete();
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();

            $table->date("from_date");
            $table->date("to_date");
            $table->time("from_time")->nullable();
            $table->time("to_time")->nullable();
            $table->integer("count_days")->unsigned()->default(0);
            $table->integer("minutes")->unsigned()->nullable();

            $table->text("description")->nullable();
            $table->text("reject_details")->nullable();
            $table->date("date_update_status")->nullable();
            $table->enum("status",["pending","approve","reject"])->default("pending");
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
        Schema::dropIfExists('leaves');
    }
};
