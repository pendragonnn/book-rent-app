<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'description',
        'publisher',
        'year',
        'isbn',
        'category_id',
        'rental_price',
        'cover_image',
    ];

    public function availableItemsCount()
    {
        return $this->items()->where('status', 'available')->count();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasManyThrough(BookLoan::class, BookItem::class);
    }

    public function items()
    {
        return $this->hasMany(BookItem::class);
    }
}
