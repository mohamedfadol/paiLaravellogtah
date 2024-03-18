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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('time_zone')->default('Asia/Kolkata');
            $table->string('logo')->nullable();
            $table->string('date_format')->default('Y-m-d');
            $table->enum('time_format', [12, 24])->default(24);
            $table->integer('created_by')->nullable();
            $table->text('landmark')->nullable();
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->char('zip_code', 7);
            $table->char('post_code', 7)->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('email')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('capital')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('email_settings')->nullable();
            $table->text('sms_settings')->nullable();
            $table->text('common_settings')->nullable();
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
        Schema::dropIfExists('businesses');
    }
};
