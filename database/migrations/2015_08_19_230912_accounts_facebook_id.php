<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountsFacebookId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('accounts', 'facebook_id')) {
            Schema::table('accounts', function(Blueprint $table) {
                $table->string('facebook_id', 255)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app('db')->statement('ALTER TABLE accounts DROP COLUMN facebook_id');
        if (Schema::hasColumn('accounts', 'facebook_id')) {
            Schema::table('accounts', function(Blueprint $table) {
                $table->dropColumn('facebook_id');
            });
        }
    }
}
