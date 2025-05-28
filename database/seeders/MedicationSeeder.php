<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medications')->insert([
            [
                'ProductName' => 'Amoxicillin',
                'Dosage' => '250mg',
                'Frequency' => 'Twice a day',
                'DurationDays' => 7,
                'Price' => 150.00,
                'Type' => 'Antibiotic',
                'StockQuantity' => 30,
                'ExpirationDate' => '2025-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ProductName' => 'Metronidazole',
                'Dosage' => '500mg',
                'Frequency' => 'Once a day',
                'DurationDays' => 5,
                'Price' => 120.00,
                'Type' => 'Antibiotic',
                'StockQuantity' => 20,
                'ExpirationDate' => '2026-03-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ProductName' => 'Carprofen',
                'Dosage' => '75mg',
                'Frequency' => 'Once a day',
                'DurationDays' => 3,
                'Price' => 200.00,
                'Type' => 'Pain Relief',
                'StockQuantity' => 15,
                'ExpirationDate' => '2025-09-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
