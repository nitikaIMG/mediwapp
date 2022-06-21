<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductQuantityToProduct extends Migration
{
    
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('product_quantity')->nullable()->after('sale_price');
        });
    }

    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('product_quantity');
        });
    }
}
