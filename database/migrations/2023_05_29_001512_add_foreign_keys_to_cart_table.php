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
        Schema::table('cart', function (Blueprint $table) {
            $table->after('id', function (Blueprint $table) {
                $table->foreignId('user_id', 'fk_cart_to_user')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreignId('product_id', 'fk_cart_to_product')->references('id')->on('product')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart', function (Blueprint $table) {
            $table->dropForeign('fk_order_product_to_order');
            $table->dropForeign('fk_order_product_to_product');
        });
    }
};
