<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderAmountToOrders extends Migration
{
   
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_amount')->after('payment_status');
        });
    }

    
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_amount');
        });
    }
}
