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
        Schema::create('member_disclosure', function (Blueprint $table) {
            $table->boolean("is_signed")->default(false);
            $table->enum('disclosure_status',['SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL'])->default('NOTSIGNED');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->unsignedBigInteger('disclosure_id')->nullable();
            $table->foreign('disclosure_id')->references('id')->on('disclosures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('member_disclosure');
    }
};
