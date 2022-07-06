<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponToUser extends Migration
{
    
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('coupon')->after('user_address');
            $table->string('wallet')->after('coupon');
            $table->string('ref_id')->after('wallet');
        });
    }

    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon');
            $table->dropColumn('wallet');
            $table->dropColumn('ref_id');
        });
    }
}
