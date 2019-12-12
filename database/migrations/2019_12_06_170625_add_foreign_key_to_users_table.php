<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('dealership_id')
                ->on('dealerships')
                ->references('id')
            ->onDelete('cascade');

            $table->foreign('group_id')
                ->on('groups')
                ->references('id')
                ->onDelete('set null');

            $table->foreign('region_id')
                ->on('regions')
                ->references('id')
                ->onDelete('set null');

            $table->foreign('country_id')
                ->on('countries')
                ->references('id')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['dealership_id', 'group_id', 'region_id', 'country_id']);
        });
    }
}