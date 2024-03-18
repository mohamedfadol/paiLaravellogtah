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
        Schema::create('action_trackers', function (Blueprint $table) {
            $table->id();
            $table->longText('tasks')->nullable();
            $table->longText('note')->nullable();
            $table->datetime('date_assigned')->nullable();
            $table->datetime('date_due')->nullable();
            $table->enum('action_status',['DELAYED','CANCELED','ONGOING','NOTSTARTED','COMPLETE'])->default('ONGOING');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->unsignedBigInteger('meeting_id')->nullable();
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->unsignedBigInteger('agenda_detail_id')->nullable();
            $table->foreign('agenda_detail_id')->references('id')->on('agenda_details')->onDelete('cascade');
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
        Schema::dropIfExists('action_trackers');
    }
};
