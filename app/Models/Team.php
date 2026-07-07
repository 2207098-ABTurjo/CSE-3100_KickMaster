<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}