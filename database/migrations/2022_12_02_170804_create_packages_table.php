<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->integer('location_count')->comment("No. of Business Locations, 0 = infinite option.");
            $table->integer('user_count');   
            $table->enum('interval', ['days', 'months', 'years']);
            $table->integer('interval_count');
            $table->integer('trial_days');
            $table->decimal('price', 22, 4);
            $table->longText('custom_permissions')->default(null);
            $table->integer('created_by');
            $table->boolean('is_active');
            $table->boolean('is_private')->default(0);
            $table->boolean('is_one_time')->default(0);
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
        Schema::dropIfExists('packages');
    }
};
