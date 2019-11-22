<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToBrandRegion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_region', function (Blueprint $table) {
           $table->foreign('brand_id')
               ->references('id')
               ->on('brands')
               ->onDelete('cascade');

           $table->foreign('region_id')
               ->references('id')
               ->on('regions')
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
        Schema::table('brand_region', function (Blueprint $table) {
            $table->dropForeign(['brand_id', 'region_id']);
        });
    }
}
