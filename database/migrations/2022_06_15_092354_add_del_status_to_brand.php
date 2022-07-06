<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDelStatusToBrand extends Migration
{
    
    public function up()
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->string('del_status')->default('1')->after('status');
        });
    }

    public function down()
    {
        Schema::table('brand', function (Blueprint $table) {
            $table->dropColumn('del_status');
        });
    }
}
