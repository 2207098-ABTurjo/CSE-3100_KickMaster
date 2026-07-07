<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Fixture mane hocche upcoming match er schedule. Match hoye gele eta match table er sathe link thake.
class Fixture extends Model
{
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_date',
        'venue',
        'status', // scheduled, completed, cancelled
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
        ];
    }
}