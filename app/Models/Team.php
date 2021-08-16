<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'elo', 'level', 'avatar',
    ];

    public function ladder(): BelongsTo
    {
        return $this->belongsTo(Ladder::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class)->withPivot('score', 'elo_diff', 'won');
    }
}
