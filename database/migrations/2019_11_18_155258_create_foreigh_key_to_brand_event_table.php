<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeighKeyToBrandEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_event', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands');
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
        Schema::table('brand_event', function (Blueprint $table) {
            $table->dropForeign(['brand_id', 'event_id']);
        });
    }
}
