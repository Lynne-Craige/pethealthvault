<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;
use Illuminate\Support\Carbon;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = [
            [
                'ProductName'     => 'Amoxicillin',
                'Dosage'          => '250mg',
                'Frequency'       => 'Twice a day',
                'DurationDays'    => 7,
                'Price'           => 150.00,
                'Type'            => 'Antibiotic',
                'StockQuantity'   => 30,
                'ExpirationDate'  => Carbon::create('2025', '12', '31'),
            ],
            [
                'ProductName'     => 'Metronidazole',
                'Dosage'          => '500mg',
                'Frequency'       => 'Once a day',
                'DurationDays'    => 5,
                'Price'           => 120.00,
                'Type'            => 'Antibiotic',
                'StockQuantity'   => 20,
                'ExpirationDate'  => Carbon::create('2026', '03', '10'),
            ],
            [
                'ProductName'     => 'Carprofen',
                'Dosage'          => '75mg',
                'Frequency'       => 'Once a day',
                'DurationDays'    => 3,
                'Price'           => 200.00,
                'Type'            => 'Pain Relief',
                'StockQuantity'   => 15,
                'ExpirationDate'  => Carbon::create('2025', '09', '01'),
            ],
        ];

        foreach ($medications as $data) {
            Medication::firstOrCreate(
                ['ProductName' => $data['ProductName']], // Check by product name
                $data // Fill the rest
            );
        }
    }
}
