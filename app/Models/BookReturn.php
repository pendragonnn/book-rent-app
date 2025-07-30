<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    protected $fillable = [
        'loan_id', 'return_date', 'late_fee'
    ];

    public function loan()
    {
        return $this->belongsTo(BookLoan::class, 'loan_id');
    }
}

