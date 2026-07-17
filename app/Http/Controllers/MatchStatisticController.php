<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use Illuminate\Http\Request;

// Ei controller ekta match er statistics (possession, shots, corners etc) update kore
class MatchStatisticController extends Controller
{
    // Statistics update form dekhano
    public function edit(GameMatch $match)
    {
        $match->load('statistic');

        return view('matches.statistics', compact('match'));
    }

    // Statistics form submit korle database update kora hoy
    public function update(Request $request, GameMatch $match)
    {
        $validated = $request->validate([
            'home_possession' => 'required|integer|min:0|max:100',
            'away_possession' => 'required|integer|min:0|max:100',
            'home_shots' => 'required|integer|min:0',
            'away_shots' => 'required|integer|min:0',
            'home_shots_on_target' => 'required|integer|min:0',
            'away_shots_on_target' => 'required|integer|min:0',
            'home_corners' => 'required|integer|min:0',
            'away_corners' => 'required|integer|min:0',
            'home_fouls' => 'required|integer|min:0',
            'away_fouls' => 'required|integer|min:0',
            'home_yellow_cards' => 'required|integer|min:0',
            'away_yellow_cards' => 'required|integer|min:0',
            'home_red_cards' => 'required|integer|min:0',
            'away_red_cards' => 'required|integer|min:0',
        ]);

        // updateOrCreate use kora hoyeche jate statistic row na thakleo create hoye jay
        $match->statistic()->updateOrCreate(['match_id' => $match->id], $validated);

        return redirect()->route('matches.show', $match)->with('success', 'Match statistics updated!');
    }
}