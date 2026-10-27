<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('payment_method', 20)->nullable()->after('status');

            $table->decimal('cash_amount', 10, 2)->nullable()->after('payment_method');

            $table->decimal('card_amount', 10, 2)->nullable()->after('cash_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'cash_amount', 'card_amount']);
        });
    }
};
