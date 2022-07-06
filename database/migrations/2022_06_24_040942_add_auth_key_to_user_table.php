<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthKeyToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
          $table->longText('auth_key')->nullable()->after('user_address');
          $table->string('code')->nullable()->after('user_email');
          $table->string('coupon')->nullable()->change();
          $table->string('wallet')->nullable()->change();
          $table->string('ref_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
          $table->dropColumn('auth_key');
          $table->dropColumn('code');
        });
    }
}
