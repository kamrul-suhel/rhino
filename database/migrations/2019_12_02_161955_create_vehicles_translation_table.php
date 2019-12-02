<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles_translation', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->unsignedBigInteger('vehicle_id')->index();
            $table->unsignedBigInteger('language_id')->index();
            $table->string('model', 120);
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
        Schema::dropIfExists('vehicles_translation');


    }
}
