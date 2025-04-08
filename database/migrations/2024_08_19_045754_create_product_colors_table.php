<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductColorsTable extends Migration
{
    public function up()
    {
        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('color', ['white', 'black', 'grey', 'red', 'green', 'blue', 'yellow']);
            $table->timestamps();
        });

        Schema::table('sizes', function (Blueprint $table) {
            $table->foreignId('product_color_id')->constrained('product_colors')->onDelete('cascade');
            $table->dropForeign(['product_id']);  // Remove old product_id foreign key
            $table->dropColumn('product_id');     // Remove product_id column
        });
    }

    public function down()
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->dropForeign(['product_color_id']);
            $table->dropColumn('product_color_id');
        });

        Schema::dropIfExists('product_colors');
    }
}
