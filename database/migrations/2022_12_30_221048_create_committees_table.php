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
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('committee_name')->nullable();
            $table->string('charter_committee')->nullable();
            $table->string('charter_name')->nullable();
            $table->string('serial_number')->nullable();
            
            $table->unsignedBigInteger('board_id')->nullable();
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');

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
        Schema::dropIfExists('committees');
    }
};
