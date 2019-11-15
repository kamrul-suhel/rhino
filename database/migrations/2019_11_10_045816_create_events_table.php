<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('start');
            $table->date('end');
            $table->unsignedBigInteger('dealership_id');
            $table->unsignedBigInteger('type_id');
            $table->string('default_language');
            $table->boolean('active');
            $table->longText('notes');
            $table->string('greeting');
            $table->timestamps();

            $table->foreign('dealership_id')->references('id')->on('dealerships');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
