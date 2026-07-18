<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\TourPackage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedImages();

        User::query()->updateOrCreate(
            ['email' => 'krizki.work@gmail.com'],
            [
                'name' => 'Admin Desa Wisata',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ],
        );

        $destinations = collect([
            [
                'name' => 'Kebun Sayur Sumberbrantas',
                'short_description' => 'Hamparan pertanian dataran tinggi dengan udara sejuk dan panorama pegunungan.',
                'ticket_price' => 10000,
                'operating_hours' => '07.00 - 17.00 WIB',
                'address' => 'Desa Sumberbrantas, Kecamatan Bumiaji, Kota Batu',
                'latitude' => -7.744112,
                'longitude' => 112.529877,
                'cover_image' => 'seed/destination-1.svg',
                'is_featured' => true,
            ],
            [
                'name' => 'Titik Nol Brantas',
                'short_description' => 'Kawasan edukasi alam untuk mengenal sumber mata air Sungai Brantas.',
                'ticket_price' => 15000,
                'operating_hours' => '08.00 - 16.00 WIB',
                'address' => 'Kawasan Sumber Mata Air Brantas, Sumberbrantas',
                'latitude' => -7.742681,
                'longitude' => 112.531246,
                'cover_image' => 'seed/destination-2.svg',
                'is_featured' => true,
            ],
            [
                'name' => 'Bukit Teletubbies Cangar',
                'short_description' => 'Perbukitan hijau dengan jalur foto, sunrise, dan pemandangan Kota Batu.',
                'ticket_price' => 12000,
                'operating_hours' => '05.30 - 17.30 WIB',
                'address' => 'Jalur Cangar, Desa Sumberbrantas',
                'latitude' => -7.735991,
                'longitude' => 112.534320,
                'cover_image' => 'seed/destination-3.svg',
                'is_featured' => true,
            ],
        ])->map(function (array $data): Destination {
            $destination = Destination::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    ...$data,
                    'slug' => Str::slug($data['name']),
                    'description' => $data['short_description'].' Cocok untuk wisata keluarga, edukasi, fotografi, dan perjalanan komunitas yang ingin menikmati suasana desa pegunungan.',
                    'status' => Destination::STATUS_PUBLISHED,
                ],
            );

            $destination->images()->delete();
            foreach (range(1, 3) as $index) {
                $destination->images()->create([
                    'image' => "seed/gallery-{$index}.svg",
                    'caption' => "{$destination->name} - Foto {$index}",
                    'sort_order' => $index,
                ]);
            }

            return $destination;
        });

        $packages = collect([
            ['name' => 'Paket Edukasi Pertanian', 'price' => 125000, 'duration' => '1 Hari', 'cover_image' => 'seed/package-1.svg'],
            ['name' => 'Paket Jelajah Sumber Brantas', 'price' => 175000, 'duration' => '1 Hari', 'cover_image' => 'seed/package-2.svg'],
            ['name' => 'Paket Camping Cangar', 'price' => 275000, 'duration' => '2 Hari 1 Malam', 'cover_image' => 'seed/package-3.svg'],
        ])->map(fn (array $data): TourPackage => TourPackage::query()->updateOrCreate(
            ['slug' => Str::slug($data['name'])],
            [
                ...$data,
                'slug' => Str::slug($data['name']),
                'description' => 'Paket wisata Desa Sumberbrantas dengan pemandu lokal, aktivitas terkurasi, dan dukungan pelaku UMKM desa.',
                'facility' => "Pemandu lokal\nTiket masuk\nAir mineral\nDokumentasi dasar",
                'status' => TourPackage::STATUS_PUBLISHED,
            ],
        ));

        foreach ($packages as $index => $package) {
            Reservation::query()->updateOrCreate(
                ['email' => "pengunjung{$index}@example.com", 'reservation_date' => now()->addDays($index + 3)->toDateString()],
                [
                    'tour_package_id' => $package->id,
                    'visitor_name' => "Pengunjung {$index}",
                    'phone' => '62812345678'.$index,
                    'total_people' => 4 + $index,
                    'notes' => 'Reservasi dummy untuk pengujian admin.',
                    'status' => Reservation::STATUS_MENUNGGU_PEMBAYARAN,
                    'payment_status' => Reservation::PEMBAYARAN_BELUM_DIBAYAR,
                ],
            );
        }

        foreach ([
            ['title' => 'Festival Sayur Sumberbrantas', 'start_date' => now()->addWeeks(2), 'cover_image' => 'seed/event-1.svg'],
            ['title' => 'Jelajah Mata Air Brantas', 'start_date' => now()->addMonth(), 'cover_image' => 'seed/event-2.svg'],
        ] as $event) {
            Event::query()->updateOrCreate(
                ['slug' => Str::slug($event['title'])],
                [
                    ...$event,
                    'slug' => Str::slug($event['title']),
                    'description' => 'Agenda wisata desa yang menghadirkan pengalaman alam, budaya, dan UMKM lokal.',
                    'location' => 'Desa Sumberbrantas',
                    'end_date' => $event['start_date']->copy()->addHours(4),
                    'status' => Event::STATUS_PUBLISHED,
                ],
            );
        }

        foreach (range(1, 6) as $index) {
            Gallery::query()->updateOrCreate(
                ['title' => "Galeri Sumberbrantas {$index}"],
                [
                    'category' => $index % 2 === 0 ? 'Alam' : 'Aktivitas',
                    'image' => "seed/gallery-{$index}.svg",
                    'description' => 'Dokumentasi suasana Desa Wisata Sumberbrantas.',
                    'taken_at' => now()->subDays($index),
                ],
            );
        }

        foreach ([
            ['name' => 'Keripik Kentang Sumberbrantas', 'price' => 25000, 'stock' => 50, 'image' => 'seed/product-1.svg'],
            ['name' => 'Sayur Segar Petani Lokal', 'price' => 30000, 'stock' => 40, 'image' => 'seed/product-2.svg'],
            ['name' => 'Kopi Lereng Arjuno', 'price' => 45000, 'stock' => 25, 'image' => 'seed/product-3.svg'],
        ] as $product) {
            Product::query()->updateOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    ...$product,
                    'slug' => Str::slug($product['name']),
                    'description' => 'Produk UMKM pilihan dari masyarakat Desa Sumberbrantas.',
                    'whatsapp_number' => '6281234567890',
                    'status' => Product::STATUS_PUBLISHED,
                ],
            );
        }

        foreach ($this->settings() as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value_type' => in_array($key, ['hero_image', 'qris_barcode'], true) ? 'image' : 'text',
                    'value' => $value,
                    'autoload' => true,
                ],
            );
        }
    }

    private function seedImages(): void
    {
        foreach ([
            'destination' => '#3f7d20',
            'package' => '#2563eb',
            'event' => '#b45309',
            'gallery' => '#0f766e',
            'product' => '#be123c',
        ] as $type => $color) {
            foreach (range(1, 6) as $index) {
                Storage::disk('public')->put("seed/{$type}-{$index}.svg", $this->svg("{$type} {$index}", $color));
            }
        }

        Storage::disk('public')->put('seed/hero.svg', $this->svg('Desa Wisata Sumberbrantas', '#166534'));
        Storage::disk('public')->put('seed/qris-barcode.svg', $this->svg('QRIS Wisata Brakseng', '#0f766e'));
    }

    private function svg(string $label, string $color): string
    {
        $title = e(Str::headline($label));

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="800" viewBox="0 0 1200 800" role="img" aria-label="{$title}">
  <rect width="1200" height="800" fill="{$color}"/>
  <path d="M0 560 L260 350 L430 480 L650 260 L1200 600 L1200 800 L0 800 Z" fill="#f8fafc" fill-opacity=".86"/>
  <path d="M0 640 L280 460 L500 610 L760 360 L1200 680 L1200 800 L0 800 Z" fill="#dcfce7" fill-opacity=".72"/>
  <circle cx="970" cy="150" r="82" fill="#fde68a"/>
  <text x="80" y="130" font-family="Arial, sans-serif" font-size="52" font-weight="700" fill="#ffffff">{$title}</text>
</svg>
SVG;
    }

    private function settings(): array
    {
        return [
            'alamat' => 'Desa Sumberbrantas, Kecamatan Bumiaji, Kota Batu, Jawa Timur',
            'email' => 'info@sumberbrantas.id',
            'email_admin_pemesanan' => 'info@sumberbrantas.id',
            'telepon' => '+62 812-3456-7890',
            'google_maps_embed' => 'https://www.google.com/maps?q=Desa%20Sumberbrantas%20Bumiaji%20Batu&output=embed',
            'youtube' => 'https://www.youtube.com/',
            'instagram' => 'https://www.instagram.com/',
            'facebook' => 'https://www.facebook.com/',
            'tiktok' => 'https://www.tiktok.com/',
            'hero_title' => 'Desa Wisata Sumberbrantas',
            'hero_subtitle' => 'Wisata alam, edukasi pertanian, dan UMKM lokal di hulu Sungai Brantas.',
            'hero_image' => 'seed/hero.svg',
            'qris_barcode' => 'seed/qris-barcode.svg',
            'about' => 'Sumberbrantas adalah desa wisata dataran tinggi di Kota Batu yang dikenal dengan lanskap pertanian, udara sejuk, dan aktivitas wisata berbasis masyarakat.',
            'profile_video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        ];
    }
}
