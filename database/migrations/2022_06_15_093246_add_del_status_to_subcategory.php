<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDelStatusToSubcategory extends Migration
{
    public function up()
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->string('del_status')->default('1')->after('status');
        });
    }

    public function down()
    {
        Schema::table('subcategory', function (Blueprint $table) {
            $table->dropColumn('del_status');
        });
    }
}
