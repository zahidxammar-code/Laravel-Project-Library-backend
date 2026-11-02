<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Tampilkan daftar buku (mendukung filter genre & sorting)
    public function index(Request $request)
    {
        $query = Book::query();

        // Filter berdasarkan genre jika ada
        if ($request->has('genre') && !empty($request->genre)) {
            $query->where('genre', $request->genre);
        }

        // Sorting (A-Z, Z-A, Stok Naik/Turun)
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('title', 'asc');
                    break;
                case 'za':
                    $query->orderBy('title', 'desc');
                    break;
                case 'stock_asc':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'stock_desc':
                    $query->orderBy('stock', 'desc');
                    break;
            }
        }

        return response()->json($query->get());
    }

    // Tambah buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
        ]);

        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book
        ], 201);
    }

    // Hapus buku
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
