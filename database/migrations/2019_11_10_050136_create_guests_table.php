<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id')->index();
            $table->unsignedBigInteger('appointment_id')->index()->nullable();
            $table->string('unique');
            $table->string('firstname');
            $table->string('surname');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('address_line_3');
            $table->string('address_line_4');
            $table->string('address_line_5');
            $table->string('address_line_6');
            $table->string('postcode');
            $table->string('landline');
            $table->string('mobile');
            $table->boolean('new');
            $table->boolean('used');
            $table->string('part_ex_vrm')->nullable();
            $table->string('part_ex_vehicle')->nullable();
            $table->string('part_ex_distance')->nullable();
            $table->boolean('part_ex_settlement');
            $table->boolean('confirmation_letter_sent');
            $table->boolean('postal_contact');
            $table->boolean('email_contact');
            $table->boolean('sms_contact');
            $table->string('method');
            $table->dateTime('last_logged_in');
            $table->integer('stage');
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
        Schema::dropIfExists('guests');
    }
}
