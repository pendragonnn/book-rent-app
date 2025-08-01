<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class BookLoanSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::pluck('id')->toArray();
        $members = User::where('role_id', 2)->pluck('id')->toArray();

        foreach (range(1, 10) as $i) {
            $loanDate = Carbon::now()->subDays(rand(5, 30));
            $dueDate = $loanDate->copy()->addDays(7); // default pinjam 7 hari
            $isReturned = rand(0, 1);
            $status = $isReturned ? 'returned' : 'borrowed';

            $bookId = fake()->randomElement($books);
            $book = Book::find($bookId);

            $days = $isReturned
                ? $loanDate->diffInDays($dueDate)
                : $loanDate->diffInDays(now());

            $price = $book->rental_price * ($days ?: 1);

            DB::table('book_loans')->updateOrInsert(
                [
                    'user_id' => fake()->randomElement($members),
                    'book_id' => $bookId,
                    'loan_date' => $loanDate->toDateString()
                ],
                [
                    'due_date' => $dueDate->toDateString(),
                    'status' => $status,
                    'total_price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
