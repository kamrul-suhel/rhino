<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('set null');

            $table->foreign('dealership_id')
                ->references('id')
                ->on('dealerships')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_type_id_foreign');
            $table->dropForeign('events_dealership_id_foreign');
        });
    }
}
