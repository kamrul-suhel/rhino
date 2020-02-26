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
            $table->unsignedBigInteger('dealership_id')->index()->nullable();
            $table->unsignedBigInteger('type_id')->index();
            $table->date('start');
            $table->date('end');
            $table->smallInteger('appointment_duration')->nullable();
            $table->smallInteger('break_time')->nullable();
            $table->text('banner')->nullable();
            $table->tinyInteger('status')->index()->default(1);
            $table->boolean('greeting')->nullable();
            $table->bigInteger('default_language_id')->nullable()->index()->default(1);
            $table->text('banner_image')->nullable();
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
        Schema::dropIfExists('events');
    }
}
