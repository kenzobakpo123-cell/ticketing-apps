<?php

namespace App\Console\Commands;

use App\Models\Kategori;
use App\Models\TipePembayaran;
use App\Models\User;
use Illuminate\Console\Command;

class EnsureAdminUser extends Command
{
    protected $signature = 'app:ensure-admin';

    protected $description = 'Create the initial admin using deployment environment variables.';

    public function handle(): int
    {
        $email = getenv('ADMIN_EMAIL');
        $password = getenv('ADMIN_PASSWORD');

        if (! $email || ! $password || strlen($password) < 12) {
            $this->error('Set ADMIN_EMAIL and an ADMIN_PASSWORD of at least 12 characters.');

            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);

        if ($user->exists && $user->role !== 'admin') {
            $this->error('ADMIN_EMAIL already belongs to a non-admin account.');

            return self::FAILURE;
        }

        if (! $user->exists) {
            $user->name = 'BengTix Admin';
            $user->password = $password;
            $user->role = 'admin';
            $user->save();
        }

        foreach (['Konser', 'Seminar', 'Workshop'] as $categoryName) {
            Kategori::firstOrCreate(['nama' => $categoryName]);
        }

        TipePembayaran::firstOrCreate(
            ['nama' => 'Pembayaran manual'],
            [
                'deskripsi' => 'Selesaikan pembayaran sesuai instruksi penyelenggara. Admin akan mengonfirmasi pembayaran setelah diterima.',
                'is_active' => true,
            ],
        );

        $this->info('Admin account is ready.');

        return self::SUCCESS;
    }
}
