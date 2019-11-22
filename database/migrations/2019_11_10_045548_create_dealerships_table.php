<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealerships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_id')->index();
            $table->unsignedBigInteger('group_id')->index();
            $table->float('latitude', 9, 6)->index()->nullable();
            $table->float('longitude', 9, 6)->index()->nullable();
            $table->time('monday_start');
            $table->time('monday_end');
            $table->time('tuesday_start');
            $table->time('tuesday_end');
            $table->time('wednesday_start');
            $table->time('wednesday_end');
            $table->time('thursday_start');
            $table->time('thursday_end');
            $table->time('friday_start');
            $table->time('friday_end');
            $table->time('saturday_start');
            $table->time('saturday_end');
            $table->time('sunday_start');
            $table->time('sunday_end');
            $table->tinyInteger('status')->index()->default(1);
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
        Schema::dropIfExists('dealerships');
    }
}
