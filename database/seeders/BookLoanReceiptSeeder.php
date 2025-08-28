<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookLoan;
use App\Models\BookLoanReceipt;
use App\Models\BookLoanReceiptItem;
use App\Models\User;
use Illuminate\Support\Str;

class BookLoanReceiptSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role_id', 2)->pluck('id')->toArray();

        $loans = BookLoan::whereIn('status', ['payment_pending'])
            ->inRandomOrder()
            ->get()
            ->groupBy('user_id'); 

        foreach ($loans as $userId => $userLoans) {
            $chunks = $userLoans->chunk(rand(1, 3));

            foreach ($chunks as $chunk) {
                $totalPrice = $chunk->sum('loan_price');

                $receipt = BookLoanReceipt::create([
                    'user_id' => $userId,
                    'payment_method' => fake()->randomElement(['bank_transfer', 'cash', 'ewallet']),
                    'total_price' => $totalPrice,
                    'payment_proof' => 'proof_' . Str::random(10) . '.jpg',
                    'status' => fake()->randomElement(['pending', 'verified', 'rejected']),
                ]);

                foreach ($chunk as $loan) {
                    BookLoanReceiptItem::create([
                        'receipt_id' => $receipt->id,
                        'loan_id' => $loan->id,
                    ]);
                }
            }
        }
    }
}
