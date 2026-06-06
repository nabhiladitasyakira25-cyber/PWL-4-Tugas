<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'year',
        'publisher',
        'city',
        'cover',
        'bookshelf_id',
    ];

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function bookshelf()
    {
        return $this->belongsTo(Bookshelf::class, 'bookshelf_id', 'id');
    }
}