<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'event' => 'Konser Musik Rock',
                'tipe' => 'premium',
                'harga' => 1500000,
                'stok' => 100,
            ],
            [
                'event' => 'Konser Musik Rock',
                'tipe' => 'reguler',
                'harga' => 500000,
                'stok' => 500,
            ],
            [
                'event' => 'Pameran Seni Kontemporer',
                'tipe' => 'premium',
                'harga' => 200000,
                'stok' => 300,
            ],
            [
                'event' => 'Festival Makanan Internasional',
                'tipe' => 'premium',
                'harga' => 300000,
                'stok' => 200,
            ],
        ];
        foreach ($tickets as $ticket) {
            $event = Event::where('judul', $ticket['event'])->firstOrFail();
            unset($ticket['event']);
            Tiket::updateOrCreate(
                ['event_id' => $event->id, 'tipe' => $ticket['tipe']],
                $ticket,
            );
        }
    }
}
