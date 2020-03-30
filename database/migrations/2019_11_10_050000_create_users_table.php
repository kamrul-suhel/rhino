<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('level', 70);
            $table->unsignedBigInteger('dealership_id')->index()->nullable();
            $table->unsignedBigInteger('group_id')->index()->nullable();
            $table->unsignedBigInteger('region_id')->index()->nullable();
            $table->unsignedBigInteger('country_id')->index()->nullable();
            $table->unsignedBigInteger('manufacturer_id')->index()->nullable();
            $table->unsignedBigInteger('company_id')->index()->nullable();
            $table->longText('notes')->nullable();
            $table->text('profile_image')->nullable();
            $table->boolean('send_mail');
            $table->tinyInteger('status')->index()->default(1);
            $table->bigInteger('language_id')->nullable()->default(1);
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
}
