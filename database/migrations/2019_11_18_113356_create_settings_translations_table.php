<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigIncrements('settings_id');
            $table->unsignedBigIncrements('language_id');
            $table->string('label');
            $table->string('identifier');
            $table->string('translation');
            $table->timestamps();

            $table->index(['settings_id', 'language_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_translations');
    }
}
