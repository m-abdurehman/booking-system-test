<?php

namespace Database\Seeders;

use App\Models\ProviderService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use NunoMaduro\Collision\Provider;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProviderService::create([
            'name' => 'House Cleaning',
            'description' => 'Basic house cleaning service',
            'price' => 50.00,
            'latitude' => 31.5497,
            'longitude' => 74.3436
        ]);

        ProviderService::create([
            'name' => 'Car Wash',
            'description' => 'Complete car washing service',
            'price' => 25.00,
            'latitude' => 31.5497,
            'longitude' => 74.3436
        ]);
    }
}
