<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Ei model Player table represent kore. Ek Player ekta Team er hoy.
class Player extends Model
{
    protected $fillable = [
        'team_id',
        'name',
        'position',
        'jersey_number',
        'nationality',
        'date_of_birth',
        'photo_url',
    ];

    // Ei player kon team er
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    // Ei player er statistics (goals, assists etc)
    public function statistic(): HasOne
    {
        return $this->hasOne(PlayerStatistic::class);
    }
}