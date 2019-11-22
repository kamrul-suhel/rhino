<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyForBrandsTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function(Blueprint $table){
            $table->foreign('company_id')->references('id')->on('companies');
        });

        Schema::table('brands_translation', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands_translation', function(Blueprint $table){
            $table->dropForeign(['brand_id','language_id']);
        });

        Schema::table('brands', function(Blueprint $table){
            $table->dropForeign('company_id');
        });
    }
}
