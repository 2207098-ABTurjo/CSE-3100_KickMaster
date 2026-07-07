<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Ei model ekta specific match er statistics store kore (dui team er data ekshathe)
class MatchStatistic extends Model
{
    protected $fillable = [
        'match_id',
        'home_possession',
        'away_possession',
        'home_shots',
        'away_shots',
        'home_shots_on_target',
        'away_shots_on_target',
        'home_corners',
        'away_corners',
        'home_fouls',
        'away_fouls',
        'home_yellow_cards',
        'away_yellow_cards',
        'home_red_cards',
        'away_red_cards',
    ];
}