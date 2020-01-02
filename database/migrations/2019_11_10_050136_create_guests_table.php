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
            $table->bigInteger('language_id')->index();
            $table->string('unique', 120)->unique();
            $table->string('first_name');
            $table->string('surname');
            $table->string('email', 70)->index()->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('address_line_4')->nullable();
            $table->string('address_line_5')->nullable();
            $table->string('address_line_6')->nullable();
            $table->string('postcode');
            $table->string('landline')->nullable();
            $table->string('mobile');
            $table->string('method')->nullable();
            $table->dateTime('last_logged_in')->nullable();
            $table->smallInteger('stage')->default(1);
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
        Schema::dropIfExists('guests');
    }
}
