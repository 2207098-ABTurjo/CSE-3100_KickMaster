<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    // Ekta match er ekta statistics record thake
    public function statistic(): HasOne
    {
        return $this->hasOne(MatchStatistic::class, 'match_id');
    }
}