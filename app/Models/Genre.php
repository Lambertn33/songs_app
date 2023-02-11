<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'name'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    /**
     * Get all of the songs for the Genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class, 'genre_id', 'id');
    }
}
