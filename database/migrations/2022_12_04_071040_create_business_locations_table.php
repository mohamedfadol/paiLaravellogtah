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
        Schema::create('business_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('location_id')->nullable();
            $table->string('name', 256);
            $table->text('landmark')->nullable();
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->char('zip_code', 7);
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('custom_field1')->nullable();
            $table->string('custom_field2')->nullable();
            $table->string('custom_field3')->nullable();
            $table->string('custom_field4')->nullable();
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();

            //Indexing
            $table->index('business_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_locations');
    }
};