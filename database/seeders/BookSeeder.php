<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
        ['title' => 'Belajar Laravel Dasar', 'genre' => 'Teknologi', 'stock' => 10],
        ['title' => 'Pemrograman Web Modern', 'genre' => 'Teknologi', 'stock' => 5],
        ['title' => 'Algoritma dan Struktur Data', 'genre' => 'Teknologi', 'stock' => 8],
        ['title' => 'Sejarah Dunia Yang Disembunyikan', 'genre' => 'Sejarah', 'stock' => 4],
        ['title' => 'Perang Dunia II', 'genre' => 'Sejarah', 'stock' => 6],
        ['title' => 'Laskar Pelangi', 'genre' => 'Fiksi', 'stock' => 12],
        ['title' => 'Bumi Manusia', 'genre' => 'Fiksi', 'stock' => 7],
        ['title' => 'Filosofi Teras', 'genre' => 'Pengembangan Diri', 'stock' => 15],
    ];

    foreach ($books as $book) {
        Book::create($book);
    }
    }
}
