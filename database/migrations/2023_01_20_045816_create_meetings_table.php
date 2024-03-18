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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('meeting_title')->nullable();
            $table->longText('meeting_description')->nullable();
            $table->string('meeting_start')->nullable();
            $table->string('meeting_serial_number')->nullable();
            $table->string('meeting_end')->nullable();
            $table->string('background_color')->nullable();
            $table->string('meeting_by')->nullable();
            $table->string('meeting_media_name')->nullable();
            $table->enum('meeting_status',['SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL'])->default('NOTSIGNED');
            $table->enum('meeting_puplished',['UNPUBLISHED','PUBLISHED','ARCHIVED'])->default('UNPUBLISHED');
            $table->string('meeting_file')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_all_days')->default(false);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->boolean("hasNextMeeting")->default(false);
            $table->integer('previous_meeting_id')->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
