<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $book->update($validated);

        if ($request->filled('stock') && is_numeric($request->stock)) {
            $currentStock = $book->items()->count();
            $newStock = intval($request->stock);

            if ($newStock > $currentStock) {
                $difference = $newStock - $currentStock;
                for ($i = 0; $i < $difference; $i++) {
                    $book->items()->create(['status' => 'available']);
                }
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }
}
