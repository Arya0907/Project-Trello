<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $types = ['Makanan', 'Minuman', 'Lainnya'];

        $items = [];
        for ($i = 1; $i <= 20; $i++) {
            $items[] = [
                'type' => $faker->randomElement($types),
                'name' => $faker->words(2, true), // Nama barang dengan dua kata
                'image' => $faker->imageUrl(640, 480, 'food', true, 'Faker'), // URL gambar
                'stok' => $faker->numberBetween(10, 200), // Stok antara 10-200
                'price' => $faker->numberBetween(1000, 100000), // Harga antara 1.000 - 100.000
                'deskripsi' => $faker->sentence(10), // Deskripsi barang
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('items')->insert($items);
    }
}
