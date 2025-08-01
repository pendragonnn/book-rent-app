<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookItem;

class BookItemSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();

        foreach ($books as $book) {
            for ($i = 0; $i < $book->stock; $i++) {
                BookItem::updateOrCreate(
                    ['book_id' => $book->id, 'status' => 'available'],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
