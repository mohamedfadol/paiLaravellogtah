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
        Schema::create('canvas_items', function (Blueprint $table) {
            $table->id();
            $table->integer('canva_id')->nullable();
            $table->unsignedBigInteger('agenda_id')->nullable();
            $table->double('position_dx')->nullable();
            $table->double('position_dy')->nullable();
            $table->unsignedBigInteger('addby')->nullable();
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
        Schema::dropIfExists('canvas_items');
    }
};
