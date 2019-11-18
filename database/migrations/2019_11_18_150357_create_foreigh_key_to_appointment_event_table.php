<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeighKeyToAppointmentEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_event', function (Blueprint $table) {
            $table->foreign('appointment_id')->references('id')->on('appointments');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_event', function (Blueprint $table) {
            $table->dropForeign(['appointment_id', 'event_id']);
        });
    }
}
