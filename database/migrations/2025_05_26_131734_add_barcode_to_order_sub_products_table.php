<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('order_sub_products', 'barcode')) {
            Schema::table('order_sub_products', function (Blueprint $table) {
                $table->string('barcode')->nullable()->after('sub_product_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_sub_products', function (Blueprint $table) {
            $table->dropColumn('barcode');
        });
    }
};
