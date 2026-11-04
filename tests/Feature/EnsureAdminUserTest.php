<?php

use App\Models\Kategori;
use App\Models\TipePembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('deployment admin command creates the initial administrator from environment variables', function () {
    $previousEmail = getenv('ADMIN_EMAIL');
    $previousPassword = getenv('ADMIN_PASSWORD');

    putenv('ADMIN_EMAIL=deploy-admin@example.com');
    putenv('ADMIN_PASSWORD=secure-deploy-password-123');

    try {
        $this->artisan('app:ensure-admin')
            ->assertSuccessful();

        $admin = User::where('email', 'deploy-admin@example.com')->firstOrFail();
        expect($admin->role)->toBe('admin')
            ->and(Hash::check('secure-deploy-password-123', $admin->password))->toBeTrue();
        expect(Kategori::count())->toBe(3)
            ->and(TipePembayaran::where('is_active', true)->exists())->toBeTrue();

        $admin->update(['password' => 'changed-password-456']);
        $this->artisan('app:ensure-admin')->assertSuccessful();

        expect(Hash::check('changed-password-456', $admin->fresh()->password))->toBeTrue();
    } finally {
        putenv('ADMIN_EMAIL'.($previousEmail === false ? '' : '='.$previousEmail));
        putenv('ADMIN_PASSWORD'.($previousPassword === false ? '' : '='.$previousPassword));
    }
});

test('deployment admin command rejects a missing or weak admin password', function () {
    $previousEmail = getenv('ADMIN_EMAIL');
    $previousPassword = getenv('ADMIN_PASSWORD');

    putenv('ADMIN_EMAIL=deploy-admin@example.com');
    putenv('ADMIN_PASSWORD=short');

    try {
        $this->artisan('app:ensure-admin')
            ->assertFailed();
    } finally {
        putenv('ADMIN_EMAIL'.($previousEmail === false ? '' : '='.$previousEmail));
        putenv('ADMIN_PASSWORD'.($previousPassword === false ? '' : '='.$previousPassword));
    }
});
