<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToCountriesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('countries_translation', function (Blueprint $table) {
            $table->foreign('language_id')
                ->on('languages')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('country_id')
                ->on('countries')
                ->references('id')
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
        Schema::table('countries_translation', function (Blueprint $table) {
            $table->dropForeign('countries_translation_language_id_foreign');
            $table->dropForeign('countries_translation_country_id_foreign');
        });
    }
}
