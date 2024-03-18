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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->longText('member_profile_image')->nullable();
            $table->text('signature')->nullable();
            $table->longText('member_biography')->nullable();
            $table->string('member_first_name')->nullable();
            $table->string('member_middel_name')->nullable();
            $table->string('member_last_name')->nullable();
            $table->string('member_mobile')->nullable();
            $table->string('member_email')->unique();
            $table->string('member_password')->nullable();
            $table->string('name_password')->nullable();
            $table->text('member_signature')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('has_vote')->default(false);
            $table->string('member_type')->default("member");
            $table->integer('created_by')->nullable();

            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            
            $table->unsignedBigInteger('business_id')->nullable();
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
        Schema::dropIfExists('members');
    }
};
