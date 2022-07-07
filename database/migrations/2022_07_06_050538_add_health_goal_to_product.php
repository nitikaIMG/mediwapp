<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthGoalToProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('health_goal')->nullable();
        });
    }

    
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
           $table->dropColumn('health_goal');
        });
    }
}
