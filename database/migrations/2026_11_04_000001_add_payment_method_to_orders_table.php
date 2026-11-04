<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('tipe_pembayaran_id')
                ->nullable()
                ->after('total_harga')
                ->constrained('tipe_pembayarans')
                ->nullOnDelete();
            $table->string('payment_method_name')->nullable();
            $table->text('payment_instructions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tipe_pembayaran_id');
            $table->dropColumn(['payment_method_name', 'payment_instructions']);
        });
    }
};
