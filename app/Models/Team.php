<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Ei model Team table represent kore. Ek Team er onek Player o Match thakte pare.
class Team extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'country',
        'logo_url',
        'founded_year',
        'stadium',
        'coach_name',
    ];

    // Team er shob player
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}