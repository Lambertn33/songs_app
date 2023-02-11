<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Song extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'title', 'length', 'genre_id', 'album_id'
    ];

    protected $casts = [
        'id' => 'string',
        'genre_id' => 'string',
        'album_id' => 'string'
    ];

    /**
     * Get the genre that owns the Song
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }

    /**
     * Get the album that owns the Song
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}
