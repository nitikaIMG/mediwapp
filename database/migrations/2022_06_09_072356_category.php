<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class category extends Migration
{
   
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name')->nullable();
            $table->string('subcategory_id')->nullable();
            $table->string('category_image')->nullable();
            $table->string('category_type')->nullable();
            $table->string('cat_desc')->nullable();
            $table->string('cat_status')->default('1');
            $table->softDeletes();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
