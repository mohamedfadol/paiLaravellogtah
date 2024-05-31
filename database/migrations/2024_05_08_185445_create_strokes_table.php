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
        Schema::create('strokes', function (Blueprint $table) {
            $table->id();
            $table->text('points');
            $table->json('position');
            $table->integer('page_index');
            $table->integer('stroke_color');
            $table->double('stroke_width',8,2);
            $table->string('stroke_cap');
            $table->string('file_name');
            $table->string('file_full_path');
            $table->string('file_edited')->nullable();
            $table->boolean('isPrivate')->default(false);
            $table->unsignedBigInteger('addby')->nullable();
            $table->unsignedBigInteger('agenda_id')->nullable();
            $table->unsignedBigInteger('canvas_item_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
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
        Schema::dropIfExists('strokes');
    }
};
