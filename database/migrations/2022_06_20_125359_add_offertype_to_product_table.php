<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOffertypeToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('offer_type')->nullable()->after('offer');
        });
    }

   
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
           $table->dropColumn('offer_type');
        });
    }
}
