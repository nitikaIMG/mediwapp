<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Slider extends Migration
{
    
    public function up()
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slider_title')->nullable();
            $table->string('slider_content')->nullable();
            $table->string('status')->default('1');
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('slider');

    }
}
