<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 'Match' PHP er reserved keyword tai amra class er naam GameMatch dilam,
// kintu table naam 'matches' e ache
class GameMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_date',
        'venue',
        'home_score',
        'away_score',
        'status', // upcoming, live, completed
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
        ];
    }
}