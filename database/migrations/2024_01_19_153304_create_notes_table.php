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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->longText('note')->nullable();
            $table->string('annotation_id')->nullable();
            $table->double('positionDx')->nullable();
            $table->double('positionDy')->nullable();
            $table->integer('page_index')->nullable();
            $table->boolean('isPrivate')->default(false);
            $table->string('file_edited')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            // $table->unsignedBigInteger('member_id')->nullable();
            // $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
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
        Schema::dropIfExists('notes');
    }
};
