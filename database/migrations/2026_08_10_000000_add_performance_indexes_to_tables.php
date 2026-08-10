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
        Schema::table('sales', function (Blueprint $table) {
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
        });

        Schema::table('sale_details', function (Blueprint $table) {
            $table->index(['sale_id', 'product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('stock');
            $table->index('model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('sale_details', function (Blueprint $table) {
            $table->dropIndex(['sale_id', 'product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['stock']);
            $table->dropIndex(['model']);
        });
    }
};
