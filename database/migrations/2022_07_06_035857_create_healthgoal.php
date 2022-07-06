<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthgoal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('healthgoal', function (Blueprint $table) {
            $table->id();
            $table->string('health_goals')->nullable();
            $table->string('del_status')->default('1');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('healthgoal');
    }
}
