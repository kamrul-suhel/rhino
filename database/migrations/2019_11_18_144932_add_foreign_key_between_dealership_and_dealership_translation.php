<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyBetweenDealershipAndDealershipTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealerships', function(Blueprint $table){
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('set null');
        });

        Schema::table('dealerships_translation', function (Blueprint $table) {
            $table->foreign('dealership_id')
                ->references('id')
                ->on('dealerships')
                ->onDelete('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');
        });

        Schema::table('groups_translation', function (Blueprint $table) {
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dealerships', function(Blueprint $table){
            $table->dropForeign(['country_id', 'group_id']);
        });

        Schema::table('dealerships_translation', function(Blueprint $table){
            $table->dropForeign(['dealership_id', 'language_id']);
        });
    }
}
