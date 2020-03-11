<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKyToAppointmentVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_vehicles', function (Blueprint $table) {
            $table->foreign('appointment_id')
                ->on('appointments')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('vehicle_id')
                ->on('vehicles')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_vehicles', function (Blueprint $table) {
            $table->dropForeign(
                [
                    'appointment_id',
                    'vehicle_id'
                ]
            );
        });
    }
}
