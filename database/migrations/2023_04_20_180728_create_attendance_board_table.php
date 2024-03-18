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
        Schema::create('attendance_board', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_attended')->default(false);
            $table->string('attended_name')->nullable();
            $table->string('position')->nullable();
            $table->unsignedBigInteger('minute_id')->nullable();
            $table->foreign('minute_id')->references('id')->on('minutes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_board');
    }
};
