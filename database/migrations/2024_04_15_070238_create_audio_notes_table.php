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
        Schema::create('audio_notes', function (Blueprint $table) {
            $table->id();
            $table->string('audio_name')->nullable();
            $table->string('audio_random_name')->nullable();
            $table->integer('audio_id')->nullable();
            $table->string('file_full_path')->nullable();
            $table->string('audio_time')->nullable();
            $table->double('positionDx')->nullable();
            $table->double('positionDy')->nullable();
            $table->integer('page_index')->nullable();
            $table->boolean('is_private')->default(false);
            $table->integer('addby')->nullable();
            $table->integer('agenda_id')->nullable();
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
        Schema::dropIfExists('audio_notes');
    }
};
