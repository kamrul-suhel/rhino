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
            $table->string('unique');
            $table->string('first_name');
            $table->string('surname');
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('address_line_4')->nullable();
            $table->string('address_line_5')->nullable();
            $table->string('address_line_6')->nullable();
            $table->string('postcode');
            $table->string('landline')->nullable();
            $table->string('mobile');
            $table->string('part_ex_vrm')->nullable();
            $table->string('part_ex_vehicle')->nullable();
            $table->string('part_ex_distance')->nullable();
            $table->boolean('part_ex_settlement')->nullable();
            $table->boolean('confirmation_letter_sent')->default(0);
            $table->boolean('postal_contact')->default(0);
            $table->boolean('email_contact')->default(0);
            $table->boolean('sms_contact')->default(0);
            $table->string('method')->nullable();
            $table->dateTime('last_logged_in')->nullable();
            $table->smallInteger('stage')->default(1);
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
