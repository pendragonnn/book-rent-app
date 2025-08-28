<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookItem;
use App\Models\User;
use App\Models\BookLoan;
use Carbon\Carbon;

class BookLoanSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role_id', 2)->pluck('id')->toArray();
        $bookItems = BookItem::where('status', 'available')->inRandomOrder()->take(10)->get();

        foreach ($bookItems as $bookItem) {
            $loanDate = Carbon::now()->subDays(rand(5, 30));
            $dueDate = $loanDate->copy()->addDays(7);
            $statusList = ['payment_pending', 'admin_validation', 'borrowed', 'returned', 'cancelled'];
            $status = fake()->randomElement($statusList);
            $isReturned = $status === 'returned';

            $days = $isReturned
                ? $loanDate->diffInDays($dueDate)
                : $loanDate->diffInDays(now());

            $price = $bookItem->book->rental_price * ($days ?: 1);

            BookLoan::updateOrCreate(
                [
                    'book_item_id' => $bookItem->id,
                    'user_id' => fake()->randomElement($members),
                    'loan_date' => $loanDate->toDateString(),
                ],
                [
                    'due_date' => $dueDate->toDateString(),
                    'status' => $status,
                    'loan_price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            if (in_array($status, ['borrowed', 'admin_validation', 'payment_pending'])) {
                $bookItem->update(['status' => 'borrowed']);
            }
        }
    }
}
