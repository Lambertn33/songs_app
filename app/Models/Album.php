<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id','title', 'release_date', 'description', 'image', 'user_id'
    ];

    protected $casts = [
        'id' => 'string', 
        'user_id' => 'string'
    ];

    /**
     * Get the user that owns the Album
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all of the songs for the Genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class, 'album_id', 'id');
    }

    public function getAlbumImage()
    {
        return url('storage/images'. $this->image);
    }
}
