<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyBetweenDealershipAndBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_dealership', function(Blueprint $table){
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('dealership_id')->references('id')->on('dealerships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_dealership', function(Blueprint $table){
            $table->dropForeign(['brand_id', 'dealership_id']);
        });
    }
}
