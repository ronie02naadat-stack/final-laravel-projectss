<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotion::create([
            'title' => '50% Off - Limited Time!',
            'description' => '50% off all items! Don\'t miss out on this exclusive offer.',
            'discount_percentage' => 50,
            'start_date' => now(),
            'end_date' => now()->setDate(2026, 5, 5)->setTime(23, 59, 59),
            'is_active' => true,
            'banner_color' => '#ff6b6b',
        ]);
    }
}
