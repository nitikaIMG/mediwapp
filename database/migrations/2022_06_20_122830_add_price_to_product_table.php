<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToProductTable extends Migration
{
    
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->string('price')->nullable()->after('subcategory_id');
            $table->string('opening_quantity')->nullable()->after('category_id');
            $table->string('min_quantity')->nullable()->after('category_id');
            $table->string('offer')->nullable()->after('status');
            $table->string('validate_date')->nullable()->after('status');
            $table->string('brand_image')->nullable()->after('status');
            $table->string('package_type')->nullable()->after('status');
        });
    }

   
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('opening_quantity');
            $table->dropColumn('min_quantity');
            $table->dropColumn('offer');
            $table->dropColumn('validate_date');
            $table->dropColumn('brand_image');
            $table->dropColumn('package_type');
        });
    }
}
