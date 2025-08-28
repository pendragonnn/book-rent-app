<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookItem;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;


class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'description' => 'nullable|string',
            'publisher' => 'nullable|string|max:100',
            'year' => 'nullable|digits:4',
            'isbn' => 'nullable|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'rental_price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $filename = time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('covers'), $filename);
            $validated['cover_image'] = $filename;
        }

        $book = Book::create($validated);
        if ($request->filled('stock') && is_numeric($request->stock)) {
            for ($i = 0; $i < $request->stock; $i++) {
                $book->items()->create(['status' => 'available']);
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'description' => 'nullable|string',
            'publisher' => 'nullable|string|max:100',
            'year' => 'nullable|digits:4',
            'isbn' => 'nullable|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'rental_price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $filename = time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('covers'), $filename);
            $validated['cover_image'] = $filename;
        }

        // Hitung stok existing
        $currentStock = $book->items()->count();
        $availableCount = $book->items()->where('status', 'available')->count();

        $newStock = $request->stock;

        if ($newStock > $currentStock) {
            // Tambah stok → insert BookItem baru
            $itemsToAdd = $newStock - $currentStock;
            for ($i = 0; $i < $itemsToAdd; $i++) {
                $book->items()->create([
                    'status' => 'available',
                ]);
            }
        } elseif ($newStock < $currentStock) {
            // Kurangi stok → cek apakah cukup available
            $itemsToRemove = $currentStock - $newStock;

            if ($itemsToRemove > $availableCount) {
                return back()->withErrors([
                    'stock' => 'Tidak bisa mengurangi stok karena ada buku yang masih dipinjam.',
                ]);
            }

            $book->items()
                ->where('status', 'available')
                ->take($itemsToRemove)
                ->delete();
        }
        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book, Request $request)
    {
        // Validasi konfirmasi
        $confirmationText = "saya mengetahui bahwa penghapusan ini akan mempengaruhi data lain dan saya sudah memeriksanya";
        if ($request->input('delete_confirmation') !== $confirmationText) {
            return redirect()->back()
                ->with('error', 'Konfirmasi penghapusan salah. Harap ketik kalimat dengan benar.');
        }
        // // cek apakah masih ada item yang dipinjam
        $hasBorrowed = $book->items()->where('status', 'borrowed')->exists();
        $hasReserved = $book->items()->where('status', 'reserved')->exists();

        // // dd($hasBorrowed);

        if ($hasBorrowed) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena masih ada item yang sedang dipinjam.');
        } elseif ($hasReserved) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Buku tidak bisa dihapus karena masih ada item yang sudah direservasi.');
        }

        // kalau aman → hapus semua item dulu baru bukunya
        $book->items()->delete();
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }

}
