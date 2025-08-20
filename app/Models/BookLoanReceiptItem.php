<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoanReceiptItem extends Model
{
    protected $fillable = ['receipt_id', 'loan_id'];

    public function receipt()
    {
        return $this->belongsTo(BookLoanReceipt::class, 'receipt_id');
    }

    public function loan()
    {
        return $this->belongsTo(BookLoan::class, 'book_loan_id');
    }
}
