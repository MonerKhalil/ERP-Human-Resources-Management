<?php

use App\Models\Decision;
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
        Schema::create('decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("type_decision_id")->constrained("type_decisions")->restrictOnDelete();
            $table->foreignId("session_decision_id")->constrained("session_decisions")->restrictOnDelete();
            $table->string("number")->unique();
            $table->date("date");
            $table->text("content");
            $table->enum("effect_salary", Decision::effectSalary())->default("none");
            $table->date("end_date_decision")->nullable();
            $table->float("value")->unsigned()->nullable();
            $table->integer("rate")->unsigned()->nullable();
            $table->string("image")->nullable();
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
        Schema::dropIfExists('decisions');
    }
};
