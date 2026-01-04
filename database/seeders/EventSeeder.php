<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Event 1
        $event1 = Event::create([
            'nama_event' => 'Konser Musik Rock Indonesia',
            'deskripsi' => 'Konser musik rock terbesar di Indonesia dengan penampilan band-band legendaris. Nikmati malam yang penuh energi dan nostalgia!',
            'tanggal' => now()->addDays(30)->format('Y-m-d'),
            'waktu' => '19:00',
            'lokasi' => 'Gelora Bung Karno, Jakarta',
            'gambar' => null,
        ]);

        Tiket::create([
            'event_id' => $event1->id,
            'jenis_tiket' => 'Regular',
            'harga' => 150000,
            'kuota' => 1000,
            'sisa_kuota' => 1000,
        ]);

        Tiket::create([
            'event_id' => $event1->id,
            'jenis_tiket' => 'VIP',
            'harga' => 500000,
            'kuota' => 200,
            'sisa_kuota' => 200,
        ]);

        Tiket::create([
            'event_id' => $event1->id,
            'jenis_tiket' => 'VVIP',
            'harga' => 1000000,
            'kuota' => 50,
            'sisa_kuota' => 50,
        ]);

        // Event 2
        $event2 = Event::create([
            'nama_event' => 'Festival Kuliner Nusantara',
            'deskripsi' => 'Festival kuliner terbesar dengan hidangan khas dari seluruh Indonesia. Rasakan cita rasa nusantara dalam satu tempat!',
            'tanggal' => now()->addDays(15)->format('Y-m-d'),
            'waktu' => '10:00',
            'lokasi' => 'ICE BSD, Tangerang',
            'gambar' => null,
        ]);

        Tiket::create([
            'event_id' => $event2->id,
            'jenis_tiket' => 'Tiket Masuk',
            'harga' => 50000,
            'kuota' => 5000,
            'sisa_kuota' => 5000,
        ]);

        Tiket::create([
            'event_id' => $event2->id,
            'jenis_tiket' => 'Tiket Premium (Termasuk Makan)',
            'harga' => 200000,
            'kuota' => 500,
            'sisa_kuota' => 500,
        ]);

        // Event 3
        $event3 = Event::create([
            'nama_event' => 'Seminar Digital Marketing 2024',
            'deskripsi' => 'Pelajari strategi digital marketing terkini dari para ahli. Tingkatkan bisnis Anda ke level selanjutnya!',
            'tanggal' => now()->addDays(7)->format('Y-m-d'),
            'waktu' => '09:00',
            'lokasi' => 'Hotel Indonesia Kempinski, Jakarta',
            'gambar' => null,
        ]);

        Tiket::create([
            'event_id' => $event3->id,
            'jenis_tiket' => 'Early Bird',
            'harga' => 300000,
            'kuota' => 100,
            'sisa_kuota' => 100,
        ]);

        Tiket::create([
            'event_id' => $event3->id,
            'jenis_tiket' => 'Regular',
            'harga' => 500000,
            'kuota' => 300,
            'sisa_kuota' => 300,
        ]);
    }
}
