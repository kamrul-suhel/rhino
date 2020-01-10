<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id')->index();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('guest_id')->index();
            $table->mediumInteger('slot_id')->index();
            $table->string('bring_guest', 120)->nullable();
            $table->tinyInteger('guest_changing_car')->default(0);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('part_ex_vrm')->nullable();
            $table->string('part_ex_vehicle')->nullable();
            $table->string('part_ex_distance')->nullable();
            $table->boolean('part_ex_settlement')->nullable();
            $table->boolean('is_canceled')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
