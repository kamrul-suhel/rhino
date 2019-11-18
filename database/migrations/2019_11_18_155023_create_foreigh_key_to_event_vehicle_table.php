<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeighKeyToEventVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_vehicle', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_vehicle', function (Blueprint $table) {
            $table->dropForeign(['event_id', 'vehicle_id']);
        });
    }
}
