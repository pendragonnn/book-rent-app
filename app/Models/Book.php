<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'description', 'publisher', 'year', 'isbn',
        'category_id', 'rental_price', 'stock', 'cover_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }
}
