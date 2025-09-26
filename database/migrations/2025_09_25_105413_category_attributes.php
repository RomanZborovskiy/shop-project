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
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('terms')->onDelete('cascade');

            $table->unique(['attribute_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_attributes', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['category_id']);
            $table->dropUnique(['attribute_id', 'category_id']);
        });

        Schema::dropIfExists('category_attributes');
        }
};
