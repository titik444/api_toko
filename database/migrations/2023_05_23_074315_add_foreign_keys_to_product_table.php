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
        Schema::table('product', function (Blueprint $table) {
            $table->after('id', function (Blueprint $table) {
                $table->foreignId('category_id', 'fk_product_to_category')->references('id')->on('category')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign('fk_post_to_category');
        });
    }
};
