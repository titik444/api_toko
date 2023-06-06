<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'            => 'Fashion',
                'slug'            => 'fashion',
                'description'     => 'Pakaian, sepatu, tas, jam tangan, dan aksesoris fashion lainnya.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Elektronik',
                'slug'            => 'elektronik',
                'description'     => 'Smartphone, laptop, kamera, perangkat audio, dan aksesori elektronik lainnya.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Kecantikan dan Perawatan Pribadi',
                'slug'            => 'kecantikan-dan-perawatan-pribadi',
                'description'     => 'Produk perawatan kulit, perawatan rambut, kosmetik, dan peralatan kecantikan.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Rumah Tangga dan Furnitur',
                'slug'            => 'rumah-tangga-dan-furnitur',
                'description'     => 'Perabotan rumah tangga, dekorasi, peralatan dapur, furnitur, dan perlengkapan rumah tangga lainnya.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Makanan dan Minuman',
                'slug'            => 'makanan-dan-minuman',
                'description'     => 'Produk makanan, minuman, makanan ringan, makanan sehat, dan produk-produk makanan khas.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Olahraga dan Outdoor',
                'slug'            => 'olahraga-dan-outdoor',
                'description'     => 'Peralatan olahraga, pakaian olahraga, perlengkapan outdoor, dan aksesori olahraga.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Mainan dan Hobi',
                'slug'            => 'mainan-dan-hobi',
                'description'     => 'Mainan anak-anak, mainan edukatif, alat musik, perlengkapan hobi, dan barang-barang koleksi.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Otomotif',
                'slug'            => 'otomotif',
                'description'     => 'Sparepart mobil, aksesori motor, peralatan dan perlengkapan otomotif.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Komputer dan Aksesoris',
                'slug'            => 'komputer-dan-aksesoris',
                'description'     => 'Komputer, laptop, aksesoris komputer, perangkat keras, dan perangkat lunak.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Perlengkapan Bayi dan Anak',
                'slug'            => 'perlengkapan-bayi-dan-anak',
                'description'     => 'Perlengkapan bayi, mainan anak-anak, pakaian anak-anak, dan produk perawatan bayi.',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        Category::insert($categories);
    }
}
