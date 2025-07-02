<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['category' => 'General', 'name' => 'Vaccination', 'price' => 35],
            ['category' => 'General', 'name' => 'Flea Medication', 'price' => 22],
            ['category' => 'General', 'name' => 'Deworming', 'price' => 6],
            ['category' => 'General', 'name' => 'Earmite Injection', 'price' => 20],
            ['category' => 'General', 'name' => 'Vet Consultation Fee', 'price' => 10],

            ['category' => 'Neutering', 'name' => 'Neutering (Male)', 'price' => 100],
            ['category' => 'Neutering', 'name' => 'Spaying (Female)', 'price' => 140],

            ['category' => 'Grooming', 'name' => 'Basic Grooming – Short Hair', 'price' => 60],
            ['category' => 'Grooming', 'name' => 'Basic Grooming – Long Hair', 'price' => 70],
            ['category' => 'Grooming', 'name' => 'Add-On Medicated Shampoo', 'price' => 8],

            ['category' => 'Lion Cut', 'name' => 'Lion Cut – Short Hair', 'price' => 110],
            ['category' => 'Lion Cut', 'name' => 'Lion Cut – Long Hair', 'price' => 120],

            ['category' => 'Boarding', 'name' => 'Boarding – Standard Cage', 'price' => 20],
            ['category' => 'Boarding', 'name' => 'Boarding – Medium Cage', 'price' => 24],
            ['category' => 'Boarding', 'name' => 'Boarding – Large Cage', 'price' => 25],
            ['category' => 'Boarding', 'name' => 'Boarding – Extra Large Cage', 'price' => 30],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
