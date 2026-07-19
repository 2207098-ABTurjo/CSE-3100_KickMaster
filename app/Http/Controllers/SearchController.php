<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

// Ei controller search functionality handle kore - AJAX diye call hoy page refresh chara
class SearchController extends Controller
{
    // Team, player, match ekshathe search kora hoy - keyword ar type diye
    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        $type = $request->get('type', 'all'); // all, team, player, match

        $teams = collect();
        $players = collect();
        $matches = collect();

        if ($type === 'all' || $type === 'team') {
            $teams = Team::where('name', 'like', '%'.$keyword.'%')->take(5)->get();
        }

        if ($type === 'all' || $type === 'player') {
            $players = Player::with('team')->where('name', 'like', '%'.$keyword.'%')->take(5)->get();
        }

        if ($type === 'all' || $type === 'match') {
            $matches = GameMatch::with(['homeTeam', 'awayTeam'])
                ->whereHas('homeTeam', fn ($q) => $q->where('name', 'like', '%'.$keyword.'%'))
                ->orWhereHas('awayTeam', fn ($q) => $q->where('name', 'like', '%'.$keyword.'%'))
                ->take(5)->get();
        }

        // AJAX request hole JSON ferot dei, na hole view dekhai
        if ($request->ajax()) {
            return response()->json([
                'teams' => $teams,
                'players' => $players,
                'matches' => $matches,
            ]);
        }

        return view('search.results', compact('teams', 'players', 'matches', 'keyword'));
    }
}