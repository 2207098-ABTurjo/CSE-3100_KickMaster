<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}