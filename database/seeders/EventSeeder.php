<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->firstOrFail();
        $events = [
            [
                'judul' => 'Konser Musik Rock',
                'deskripsi' => 'Nikmati malam penuh energi dengan band rock terkenal.',
                'tanggal_waktu' => now()->addDays(30)->setTime(19, 0),
                'lokasi' => 'Stadion Utama',
                'kategori' => 'Konser',
                'gambar' => '1769062679.jpg',
            ],
            [
                'judul' => 'Pameran Seni Kontemporer',
                'deskripsi' => 'Jelajahi karya seni modern dari seniman lokal dan internasional.',
                'tanggal_waktu' => now()->addDays(45)->setTime(10, 0),
                'lokasi' => 'Galeri Seni Kota',
                'kategori' => 'Workshop',
                'gambar' => '1769062860.png',
            ],
            [
                'judul' => 'Festival Makanan Internasional',
                'deskripsi' => 'Cicipi berbagai hidangan lezat dari seluruh dunia.',
                'tanggal_waktu' => now()->addDays(60)->setTime(12, 0),
                'lokasi' => 'Taman Kota',
                'kategori' => 'Seminar',
                'gambar' => '1769062981.jpg',
            ],
        ];
        foreach ($events as $event) {
            $kategori = Kategori::where('nama', $event['kategori'])->firstOrFail();
            unset($event['kategori']);
            Event::updateOrCreate(
                ['judul' => $event['judul']],
                $event + ['user_id' => $admin->id, 'kategori_id' => $kategori->id],
            );
        }
    }
}
