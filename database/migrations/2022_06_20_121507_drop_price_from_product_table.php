<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPriceFromProductTable extends Migration
{
   
    public function up()
    {
        if (Schema::hasColumn('product', 'sale_price')){
  
            Schema::table('product', function (Blueprint $table) {
                $table->dropColumn('sale_price');
            });
        }
    }

    
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            //
        });
    }
}
