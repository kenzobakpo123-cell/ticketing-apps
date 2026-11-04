<?php

namespace Database\Seeders;

use App\Models\TipePembayaran;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        TipePembayaran::firstOrCreate(
            ['nama' => 'Transfer / pembayaran manual'],
            [
                'deskripsi' => 'Buat pesanan terlebih dahulu. Hubungi admin/penyelenggara untuk menerima instruksi pembayaran; pesanan akan dikonfirmasi setelah pembayaran diverifikasi.',
                'is_active' => true,
            ],
        );
    }
}
