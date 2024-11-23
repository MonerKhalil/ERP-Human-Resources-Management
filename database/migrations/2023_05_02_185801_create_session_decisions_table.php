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
        Schema::create('session_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("moderator_id")->constrained("employees")->restrictOnDelete();
            $table->string("name");
            $table->date("date_session");
            $table->string("file")->nullable();
            $table->string("image")->nullable();
            $table->text("description")->nullable();
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
        Schema::dropIfExists('session_decisions');
    }
};
