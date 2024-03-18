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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('board_name')->nullable();
            $table->date('term')->nullable();
            $table->string('quorum')->nullable();
            $table->date('fiscal_year')->nullable();
            $table->string('charter_board')->nullable();
            $table->string('charter_name')->nullable();
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('boards');
    }
};
