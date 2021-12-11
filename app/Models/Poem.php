<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperPoem
 */
class Poem extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'user_id', 'likes', 'dislikes'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * Get the poem that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments associated with the poem.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes associated with the poem.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}