<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('chest', 5, 2)->nullable();
            $table->decimal('waist', 5, 2)->nullable();
            $table->decimal('hips', 5, 2)->nullable();
            $table->decimal('arm_length', 5, 2)->nullable();
            $table->decimal('foot_length', 5, 2)->nullable();
            $table->timestamps();
        });
        Schema::table('sizes', function (Blueprint $table) {
            $table->foreignId('product_color_id')->nullable()->change();
            $table->foreignId('user_measurement_id')->nullable()->constrained('user_measurements')->onDelete('cascade');
        });
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_measurement_id')->constrained('user_measurements')->onDelete('cascade');
            $table->string('preference_color')->nullable();
            $table->string('preference_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
        Schema::table('sizes', function (Blueprint $table) {
            $table->foreignId('product_color_id')->nullable(false)->change();
            $table->dropForeign(['user_measurement_id']);
            $table->dropColumn('user_measurement_id');
        });
        Schema::dropIfExists('user_measurements');
    }
};
