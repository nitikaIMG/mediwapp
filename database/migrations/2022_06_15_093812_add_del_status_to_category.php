<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDelStatusToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->string('del_status')->default('1')->after('cat_status');
        });
    }

    
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('del_status');
        });
    }
}
