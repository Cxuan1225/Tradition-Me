<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropProductIdColumnFromSize extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('sizes', 'product_id')) {
            Schema::table('sizes', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }
    }

    public function down()
    {
        if (! Schema::hasColumn('sizes', 'product_id')) {
            Schema::table('sizes', function (Blueprint $table) {
                $table->unsignedBigInteger('product_id')->after('id');
                $table->foreign('product_id')->references('id')->on('products');
            });
        }
    }
}
