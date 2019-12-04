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
            $table->unsignedBigInteger('dealership_id')->index();
            $table->unsignedBigInteger('language_id')->index();
            $table->string('name', 120)->index(); // Searchable
            $table->text('description')->nullable();
            $table->string('address_line_1')->nullable()->index(); // Make it searchable
            $table->string('address_line_2')->nullable();
            $table->string('address_line_3')->nullable();
            $table->string('address_line_4')->nullable();
            $table->string('address_line_5')->nullable();
            $table->string('address_line_6')->nullable();
            $table->string('postcode')->nullable();
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
        Schema::dropIfExists('dealerships_translation');
    }
}
