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
        Schema::create('member_financial', function (Blueprint $table) {
            $table->id();
            $table->boolean("is_signed")->default(false);
            $table->enum('financial_status',['SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL'])->default('NOTSIGNED');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->unsignedBigInteger('financial_id')->nullable();
            $table->foreign('financial_id')->references('id')->on('financials')->onDelete('cascade');
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
        Schema::dropIfExists('member_financial');
    }
};
