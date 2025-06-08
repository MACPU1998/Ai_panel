<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. افزودن ستون جدید
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->integer('amount')->nullable()->after('wallet_id'); // یا هر نوعی که فیلد قبلی داشته
        });

        // 2. کپی‌کردن داده‌ها از balance به amount
        DB::statement('UPDATE wallet_transactions SET amount = balance');

        // 3. حذف ستون balance
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }

    public function down(): void
    {
        // در صورت rollback
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->integer('balance')->nullable()->after('wallet_id');
        });

        DB::statement('UPDATE wallet_transactions SET balance = amount');

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
    }
};
