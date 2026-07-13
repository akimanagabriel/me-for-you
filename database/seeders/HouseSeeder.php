<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\HouseImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds 10 houses, each with 10 gallery images (real photos via Picsum).
     */
    public function run(): void
    {
        $faker = fake();

        $types = ['apartment', 'villa', 'townhouse', 'studio', 'bungalow'];
        $statuses = ['available', 'available', 'available', 'rented', 'unavailable']; // weighted toward available
        $pricePeriods = ['month', 'day', 'night'];
        $cities = ['Kigali', 'Musanze', 'Huye', 'Rubavu', 'Rwamagana'];
        $neighborhoods = ['Kacyiru', 'Nyarutarama', 'Remera', 'Kimihurura', 'Gacuriro', 'Kibagabaga', 'Nyamirambo', 'Gisozi'];
        $amenitiesPool = ['wifi', 'parking', 'pool', 'gym', 'security', 'generator', 'water_tank', 'garden', 'balcony', 'air_conditioning'];

        $userIds = User::pluck('id');

        for ($i = 1; $i <= 10; $i++) {
            $title = $faker->randomElement($neighborhoods) . ' ' . $faker->randomElement(['Residence', 'Apartment', 'Villa', 'House', 'Suites']) . ' ' . $faker->numberBetween(1, 999);
            $slug = Str::slug($title) . '-' . Str::random(4);

            // Deterministic-but-varied real photo per house (Lorem Picsum serves real photographs)
            $seed = 'house-' . $slug;
            $coverImage = "https://picsum.photos/seed/{$seed}-0/1200/800";

            $house = House::create([
                'user_id' => $userIds->isNotEmpty() ? $userIds->random() : null,
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->paragraphs(3, true),
                'type' => $faker->randomElement($types),
                'status' => $faker->randomElement($statuses),
                'location' => $faker->randomElement($neighborhoods),
                'city' => $faker->randomElement($cities),
                'address' => $faker->streetAddress(),
                'price' => $faker->numberBetween(150, 3000) * 1000, // RWF-style round pricing
                'currency' => 'RWF',
                'price_period' => $faker->randomElement($pricePeriods),
                'bedrooms' => $faker->numberBetween(1, 6),
                'bathrooms' => $faker->numberBetween(1, 5),
                'size_sqm' => $faker->numberBetween(45, 650),
                'amenities' => $faker->randomElements($amenitiesPool, $faker->numberBetween(3, 7)),
                'cover_image' => $coverImage,
                'is_featured' => $faker->boolean(25),
                'views_count' => $faker->numberBetween(0, 5000),
            ]);

            // 10 gallery images per house, all real photos from Lorem Picsum
            for ($j = 0; $j < 10; $j++) {
                HouseImage::create([
                    'house_id' => $house->id,
                    'image_path' => "https://picsum.photos/seed/{$seed}-{$j}/1200/800",
                    'alt_text' => $house->title . ' — photo ' . ($j + 1),
                    'is_cover' => $j === 0,
                    'sort_order' => $j,
                ]);
            }
        }
    }
}