<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDealershipSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealerships', function (Blueprint $table) {
            $table->boolean('calendar_access')->default(1)->after('status');
            $table->boolean('enable_emails')->default(1)->after('calendar_access');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dealerships', function (Blueprint $table) {
            $table->dropColumn('calendar_access');
            $table->dropColumn('enable_emails');
        });
    }
}
