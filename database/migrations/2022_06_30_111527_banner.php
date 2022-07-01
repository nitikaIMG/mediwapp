<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Banner extends Migration
{
    
    public function up()
    {
        Schema::create('banner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('banner')->nullable();
            $table->string('banner_url')->nullable();
            $table->string('status')->default('1');
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('banner');
    }
}
