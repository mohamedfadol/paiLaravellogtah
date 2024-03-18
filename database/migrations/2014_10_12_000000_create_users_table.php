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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->default('user')->index();
            $table->string('name')->default('user');
            $table->longText('profile_image')->nullable();
            $table->text('signature')->nullable();
            $table->longText('biography')->nullable();
            $table->string('name_password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->char('language', 7)->default('en');
            $table->integer('business_id')->unsigned()->nullable();
            // $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->boolean('allow_login')->default(1);
            $table->char('contact_no', 15)->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
            $table->string('gender')->nullable();
            $table->enum('marital_status', ['married', 'unmarried', 'divorced'])->nullable();
            $table->char('contact_number', 20)->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
