<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoanReceipt extends Model
{
    protected $fillable = ['user_id', 'payment_method', 'total_price', 'payment_proof', 'status'];

    public function items()
    {
        return $this->hasMany(BookLoanReceiptItem::class, 'receipt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loans()
    {
        return $this->belongsToMany(BookLoan::class, 'book_loan_receipt_items', 'receipt_id', 'book_loan_id')
                    ->withTimestamps();
    }
}
