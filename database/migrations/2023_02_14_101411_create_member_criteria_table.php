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
        Schema::create('member_criteria', function (Blueprint $table) {
            $table->id();
            $table->integer('criteria_degree')->nullable();
            
            $table->integer('total_degree')->nullable();
            
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            
            $table->boolean('has_vote')->default(false);
            
            $table->unsignedBigInteger('elected_by')->nullable();
            $table->foreign('elected_by')->references('id')->on('members')->onDelete('cascade');
            
            $table->unsignedBigInteger('criteria_id')->nullable();
            $table->foreign('criteria_id')->references('id')->on('criterias')->onDelete('cascade');
            
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
        Schema::dropIfExists('member_criteria');
    }
};
