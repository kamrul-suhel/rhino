<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_language', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('language_id');
            $table->string('name');
            $table->date('start');
            $table->date('end');
            $table->unsignedBigInteger('dealership_id');
            $table->unsignedBigInteger('type_id');

            $table->boolean('active');
            $table->longText('notes');
            $table->string('greeting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_language');
    }
}
