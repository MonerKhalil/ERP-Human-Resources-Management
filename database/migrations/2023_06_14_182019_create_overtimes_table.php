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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            #Add Columns
            $table->foreignId("employee_id")->constrained("employees")->restrictOnDelete();
            $table->foreignId("overtime_type_id")->constrained("overtime_types")->restrictOnDelete();
            $table->date("from_date");
            $table->date("to_date");
            $table->integer("count_days");
            $table->time("from_time")->nullable();
            $table->time("to_time")->nullable();
            $table->integer("count_hours_in_days")->nullable();
            $table->boolean("is_hourly")->default(false);
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
        Schema::dropIfExists('overtimes');
    }
};
