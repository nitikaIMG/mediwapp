<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToHealtgoal extends Migration
{
    
    public function up()
    {
        Schema::table('healthgoal', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('healthgoal', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
