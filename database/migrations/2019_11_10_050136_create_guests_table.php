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
            $table->bigInteger('language_id')->index()->default(1); // Default english language
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
            $table->string('postcode')->nullable();
            $table->string('landline', 20)->nullable()->index();
            $table->string('mobile', 20)->index()->nullable();
            $table->string('method', 20)->nullable()->index();
            $table->dateTime('last_logged_in')->nullable();
            $table->smallInteger('stage')->default(1)->index();
            $table->boolean('confirmation_letter_sent')->default(0);
            $table->boolean('postal_contact')->default(0);
            $table->boolean('email_contact')->default(0);
            $table->boolean('sms_contact')->default(0);
            $table->boolean('phone_contact')->default(0);
            $table->string('salutation')->nullable();
            $table->tinyInteger('status')->index()->default(0);
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
