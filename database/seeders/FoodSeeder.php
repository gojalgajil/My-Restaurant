<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    public function run(): void
    {
        $foods = [
            // Makanan
            ['name' => 'Nasi Goreng', 'description' => 'Nasi goreng dengan telur mata sapi dan kerupuk', 'category' => 'makanan', 'price' => 25000, 'available' => true],
            ['name' => 'Mie Ayam', 'description' => 'Mie ayam dengan pangsit rebus dan goreng', 'category' => 'makanan', 'price' => 22000, 'available' => true],
            ['name' => 'Ayam Bakar', 'description' => 'Ayam bakar dengan sambal dan lalapan', 'category' => 'makanan', 'price' => 35000, 'available' => true],
            ['name' => 'Soto Ayam', 'description' => 'Soto ayam dengan telur dan kerupuk', 'category' => 'makanan', 'price' => 20000, 'available' => true],
            ['name' => 'Gado-Gado', 'description' => 'Gado-gado dengan telur dan kerupuk', 'category' => 'makanan', 'price' => 18000, 'available' => true],
            ['name' => 'Rendang', 'description' => 'Rendang daging sapi dengan nasi', 'category' => 'makanan', 'price' => 45000, 'available' => true],
            ['name' => 'Cap Cay', 'description' => 'Cap cay goreng dengan seafood', 'category' => 'makanan', 'price' => 30000, 'available' => true],
            ['name' => 'Ikan Bakar', 'description' => 'Ikan bakar dengan sambal dan lalapan', 'category' => 'makanan', 'price' => 40000, 'available' => true],

            // Minuman
            ['name' => 'Es Teh Manis', 'description' => 'Teh manis dingin', 'category' => 'minuman', 'price' => 5000, 'available' => true],
            ['name' => 'Es Jeruk', 'description' => 'Jeruk peras dingin', 'category' => 'minuman', 'price' => 8000, 'available' => true],
            ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat dengan susu', 'category' => 'minuman', 'price' => 15000, 'available' => true],
            ['name' => 'Jus Mangga', 'description' => 'Jus mangga segar', 'category' => 'minuman', 'price' => 12000, 'available' => true],
            ['name' => 'Kopi Hitam', 'description' => 'Kopi hitam panas', 'category' => 'minuman', 'price' => 6000, 'available' => true],
            ['name' => 'Teh Botol', 'description' => 'Teh botol dingin', 'category' => 'minuman', 'price' => 7000, 'available' => true],
            ['name' => 'Air Mineral', 'description' => 'Air mineral 600ml', 'category' => 'minuman', 'price' => 4000, 'available' => true],
            ['name' => 'Soda Gembira', 'description' => 'Soda dengan susu dan sirup', 'category' => 'minuman', 'price' => 10000, 'available' => true],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
