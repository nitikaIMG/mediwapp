<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subcategory extends Migration
{
   
    public function up()
    {
        Schema::create('subcategory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subcategory_name')->nullable();
            $table->string('category_id')->nullable();
            $table->string('subcategory_image')->nullable();
            $table->string('status')->default('1');
            $table->softDeletes();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('subcategory');

    }
}
