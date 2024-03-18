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
        Schema::table('annual_audit_reports', function (Blueprint $table) {
            $table->enum('audit_status',['UNPUBLISHED','PUBLISHED'])->default('UNPUBLISHED');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annual_audit_reports', function (Blueprint $table) {
             $table->dropColumn('audit_status');
        });
    }
};
