<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Prescription extends Migration
{
    
    public function up()
    {
        Schema::create('prescription', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('file')->nullable();
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('prescription');
    }
}
