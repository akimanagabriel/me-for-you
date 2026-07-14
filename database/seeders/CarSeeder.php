<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $makesAndModels = [
            'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Land Cruiser', 'Hilux', 'Prado'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot'],
            'Nissan' => ['Altima', 'X-Trail', 'Patrol', 'Navara'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLE', 'GLC'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan'],
            'Ford' => ['Ranger', 'Explorer', 'Escape'],
            'Hyundai' => ['Elantra', 'Tucson', 'Santa Fe'],
            'Kia' => ['Sportage', 'Sorento', 'Cerato'],
            'Mazda' => ['Mazda3', 'CX-5', 'CX-9'],
        ];

        $bodyTypes = ['sedan', 'suv', 'hatchback', 'coupe', 'pickup', 'van', 'convertible'];
        $statuses = ['available', 'available', 'available', 'reserved', 'sold', 'unavailable'];
        $conditions = ['new', 'used', 'used', 'used', 'certified_pre_owned'];
        $fuelTypes = ['petrol', 'petrol', 'diesel', 'hybrid', 'electric'];
        $transmissions = ['automatic', 'automatic', 'manual'];
        $pricePeriods = ['total', 'total', 'total', 'day', 'month'];
        $colors = ['White', 'Black', 'Silver', 'Grey', 'Blue', 'Red', 'Brown'];
        $featurePool = [
            'ac', 'bluetooth', 'sunroof', 'backup_camera', 'leather_seats',
            'navigation', 'cruise_control', 'heated_seats', 'keyless_entry',
            'parking_sensors', 'alloy_wheels', 'third_row_seats',
        ];

        $userIds = User::pluck('id');

        for ($i = 0; $i < 15; $i++) {
            $make = fake()->randomElement(array_keys($makesAndModels));
            $model = fake()->randomElement($makesAndModels[$make]);
            $year = fake()->numberBetween(2012, 2025);
            $title = "{$year} {$make} {$model}";
            $slug = Str::slug($title) . '-' . Str::lower(Str::random(4));

            $bodyType = fake()->randomElement($bodyTypes);
            $doors = in_array($bodyType, ['coupe', 'convertible']) ? 2 : (in_array($bodyType, ['pickup', 'van']) ? fake()->randomElement([2, 4]) : 4);
            $seats = in_array($bodyType, ['van']) ? fake()->numberBetween(7, 9) : ($bodyType === 'coupe' ? 4 : fake()->numberBetween(4, 5));

            $car = Car::create([
                'user_id' => $userIds->isNotEmpty() ? fake()->randomElement($userIds->all()) : null,
                'title' => $title,
                'slug' => $slug,
                'description' => fake()->paragraphs(3, true),
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'vin' => strtoupper(Str::random(17)),
                'color' => fake()->randomElement($colors),
                'body_type' => $bodyType,
                'status' => fake()->randomElement($statuses),
                'condition' => fake()->randomElement($conditions),
                'fuel_type' => fake()->randomElement($fuelTypes),
                'transmission' => fake()->randomElement($transmissions),
                'price' => fake()->numberBetween(3_500_000, 65_000_000),
                'currency' => 'RWF',
                'price_period' => fake()->randomElement($pricePeriods),
                'mileage' => fake()->numberBetween(0, 180_000),
                'engine_capacity' => fake()->randomFloat(1, 1.0, 4.5),
                'seats' => $seats,
                'doors' => $doors,
                'features' => fake()->randomElements($featurePool, fake()->numberBetween(3, 7)),
                'cover_image' => "https://picsum.photos/seed/car-{$slug}-cover/1200/800",
                'is_featured' => fake()->boolean(20),
                'views_count' => fake()->numberBetween(0, 5000),
            ]);

            $imageCount = fake()->numberBetween(4, 8);

            $images = [];
            for ($j = 0; $j < $imageCount; $j++) {
                $images[] = [
                    'image_path' => "https://picsum.photos/seed/car-{$slug}-{$j}/1200/800",
                    'alt_text' => $title,
                    'is_cover' => $j === 0,
                    'sort_order' => $j,
                ];
            }

            $car->images()->createMany($images);
        }
    }
}