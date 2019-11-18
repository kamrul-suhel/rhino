<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealershipsTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealerships_translation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('dealership_id')->index();
            $table->string('name');
            $table->float('latitude', 9, 6)->nullable();
            $table->float('longitude', 9, 6)->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('address_line_4')->nullable();
            $table->string('address_line_5')->nullable();
            $table->string('address_line_6')->nullable();
            $table->string('postcode')->nullable();
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
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dealerships_translation');
    }
}
