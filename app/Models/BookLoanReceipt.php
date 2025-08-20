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
}
