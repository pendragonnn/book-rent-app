<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    protected $fillable = [
        'book_item_id',
        'receipt_id',
        'loan_date',
        'due_date',
        'loan_price',
        'status'
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
        return $this->belongsToMany(BookLoanReceipt::class, 'book_loan_receipt_items', 'loan_id', 'receipt_id')
            ->withTimestamps();
    }
    
}

