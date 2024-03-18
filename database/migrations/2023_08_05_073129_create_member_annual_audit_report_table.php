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
        Schema::create('member_annual_audit_report', function (Blueprint $table) {
            $table->id();
            $table->boolean("is_signed")->default(false);
            $table->enum('annual_audit_report_status',['SIGNED','QOURMREACHED','NOTSIGNED','PARTIAL'])->default('NOTSIGNED');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->unsignedBigInteger('annual_audit_report_id')->nullable();
            $table->foreign('annual_audit_report_id')->references('id')->on('annual_audit_reports')->onDelete('cascade');
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
        Schema::dropIfExists('member_annual_audit_report');
    }
};
