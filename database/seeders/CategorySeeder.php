<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Pengeluaran
        $pengeluaran = [
            'Makanan',
            'Transportasi',
            'Rumah',
            'Kesehatan',
            'Belanja',
            'Kecantikan',
            'Hiburan',
            'Pendidikan',
            'Olahraga',
            'Sedekah',
            'Darurat',
            'Lainnya',
        ];

        foreach ($pengeluaran as $item) {
            Categories::create([
                'nama' => $item,
                'status_kategori' => 'pengeluaran',
            ]);
        }

        // Pemasukan
        $pemasukkan = [
            'Gaji',
            'Freelance',
            'Bisnis',
            'Penjualan',
            'Investasi',
            'Hadiah',
            'Sewa',
            'Uang saku',
            'Lainnya',
        ];

        foreach ($pemasukkan as $item) {
            Categories::create([
                'nama' => $item,
                'status_kategori' => 'pemasukkan',
            ]);
        }
    }
}
