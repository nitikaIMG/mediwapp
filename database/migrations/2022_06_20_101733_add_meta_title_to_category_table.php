<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaTitleToCategoryTable extends Migration
{
    
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->string('parent_category')->nullable()->after('cat_desc');
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('banner')->nullable()->after('category_image');
        });
    }

    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_keyword');
            $table->dropColumn('meta_description');
            $table->dropColumn('parent_category');
            $table->string('banner')->nullable()->after('category_image');

        });
    }
}
