<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    protected $fillable = [
        'user_id',
        'book_item_id',
        'loan_date',
        'due_date',
        'status',
        'loan_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookItem()
    {
        return $this->belongsTo(BookItem::class, 'book_item_id');
    }

    public function return()
    {
        return $this->hasOne(BookReturn::class, 'loan_id');
    }

    public function receipts()
    {
        return $this->belongsToMany(BookLoanReceipt::class, 'book_loan_receipt_items', 'book_loan_id', 'receipt_id')
            ->withTimestamps();
    }
}

