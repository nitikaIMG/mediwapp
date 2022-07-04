<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusprodDesc extends Migration
{
    
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->longText('prod_desc')->change();
         });
    }

    
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->longText('prod_desc')->change();
      });
    }
}
