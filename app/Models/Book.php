<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function whereGenreIdIn($genreIds)
    {
        return $this->belongsToMany(Genre::class)
            ->wherePivotIn('genre_id', $genreIds);
    }
}
