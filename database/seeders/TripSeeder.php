<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Organizers;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories
        $categoriesData = [
            ['category_name' => 'Mountain & Trekking'],
            ['category_name' => 'Beach & Island'],
            ['category_name' => 'Culture & Heritage'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['category_name']] = Category::firstOrCreate(
                ['category_name' => $cat['category_name']],
                $cat
            );
        }

        // 2. Seed Organizers
        $organizer = Organizers::firstOrCreate(
            ['name' => 'HerTrip Nusantara Adventure'],
            [
                'contact' => '081234567890',
                'verification_status' => 'verified',
            ]
        );

        // 3. Seed Trips
        $tripsData = [
            [
                'category_id' => $categories['Mountain & Trekking']->id,
                'organizer_id' => $organizer->id,
                'title' => 'Sunrise Trekking Prau via Patak Banteng',
                'destination' => 'Dieng, Jawa Tengah',
                'date' => '2026-12-05',
                'price' => 450000,
                'quota' => 20,
                'description' => 'Open trip pendakian santai ramah pemula menikmati sunrise dan bukit teletubbies.',
            ],
            [
                'category_id' => $categories['Beach & Island']->id,
                'organizer_id' => $organizer->id,
                'title' => 'Island Hopping Labuan Bajo 3D2N',
                'destination' => 'Labuan Bajo, Nusa Tenggara Timur',
                'date' => '2026-12-12',
                'price' => 2450000,
                'quota' => 15,
                'description' => 'Jelajah Pulau Padar, Pink Beach, dan snorkeling bersama komunitas traveler perempuan.',
            ],
            [
                'category_id' => $categories['Culture & Heritage']->id,
                'organizer_id' => $organizer->id,
                'title' => 'Slow Living & Heritage Walk Yogyakarta',
                'destination' => 'Kota Yogyakarta, DI Yogyakarta',
                'date' => '2026-12-19',
                'price' => 650000,
                'quota' => 18,
                'description' => 'Kelas membatik, kunjungan situs bersejarah, dan wisata kuliner malam khas Jogja.',
            ],
        ];

        foreach ($tripsData as $trip) {
            Trip::firstOrCreate(
                ['title' => $trip['title']],
                $trip
            );
        }
    }
}