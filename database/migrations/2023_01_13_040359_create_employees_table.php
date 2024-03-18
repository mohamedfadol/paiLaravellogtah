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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->longText('member_profile_image')->nullable();
            $table->longText('member_biography')->nullable();
            $table->string('member_first_name')->nullable();
            $table->string('member_last_name')->nullable();
            $table->string('member_mobile')->nullable();
            $table->string('member_email')->unique();
            $table->string('member_password')->nullable();
            $table->string('name_password')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('has_vote')->default(false);
            $table->boolean('has_signed')->default(false);
            $table->string('member_type')->default("member");
            $table->integer('created_by')->nullable();
            $table->string('resoultion_numbers')->nullable();
            $table->morphs('morphable');
            $table->boolean("agree")->default(false);
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
        Schema::dropIfExists('employees');
    }
};
