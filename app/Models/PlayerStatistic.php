<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}