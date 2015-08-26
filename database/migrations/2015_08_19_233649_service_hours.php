<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServiceHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_hours', function(Blueprint $table) {
            $table->text('open_hours');
            $table->text('timezone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_hours', function(Blueprint $table) {
            $table->dropColumn('open_hours');
            $table->dropColumn('timezone');
        });
    }
}
