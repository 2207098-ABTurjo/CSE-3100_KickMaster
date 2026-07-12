<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Ei model player er total analytics store kore (season wise total)
class PlayerStatistic extends Model
{
    protected $fillable = [
        'player_id',
        'matches_played',
        'goals',
        'assists',
        'yellow_cards',
        'red_cards',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    // Average goals per match calculate kora hoy ekhane
    public function getAverageGoalsAttribute(): float
    {
        if ($this->matches_played === 0) {
            return 0.0;
        }

        return round($this->goals / $this->matches_played, 2);
    }
}