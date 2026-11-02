<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    // Tampilkan daftar riwayat peminjaman beserta detail bukunya
    public function index()
    {
        $loans = Loan::with('items.book')->get();
        return response()->json($loans);
    }

    // Proses peminjaman buku (Multi-item & Database Transaction)
    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.book_id' => 'required|exists:books,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $result = DB::transaction(function () use ($request) {
                // 1. Simpan data utama peminjam
                $loan = Loan::create([
                    'borrower_name' => $request->borrower_name,
                    'phone' => $request->phone,
                    'due_date' => $request->due_date,
                ]);

                // 2. Loop setiap item buku yang dipinjam
                foreach ($request->items as $itemData) {
                    $book = Book::lockForUpdate()->find($itemData['book_id']);

                    // Cek apakah stok mencukupi
                    if ($book->stock < $itemData['quantity']) {
                        throw new \Exception("Stok untuk buku '{$book->title}' tidak mencukupi. Sisa stok: {$book->stock}");
                    }

                    // Kurangi stok buku
                    $book->decrement('stock', $itemData['quantity']);

                    // Simpan ke detail loan_items
                    LoanItem::create([
                        'loan_id' => $loan->id,
                        'book_id' => $book->id,
                        'quantity' => $itemData['quantity'],
                    ]);
                }

                return $loan->load('items.book');
            });

            return response()->json([
                'message' => 'Transaksi peminjaman berhasil disimpan',
                'data' => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Transaksi gagal',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
