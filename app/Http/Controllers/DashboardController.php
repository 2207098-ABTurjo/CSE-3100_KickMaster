<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\GameMatch;
use App\Models\Player;
use App\Models\Team;

// Ei controller dashboard er summary data show kore (total team, player, match etc)
class DashboardController extends Controller
{
    public function index()
    {
        // Card e dekhanor jonno total count gula ber kora hocche
        $totalTeams = Team::count();
        $totalPlayers = Player::count();
        $totalMatches = GameMatch::count();
        $upcomingMatches = GameMatch::where('status', 'upcoming')->count();
        $completedMatches = GameMatch::where('status', 'completed')->count();

        // Shesh 5 ta fixture list dekhano hobe
        $latestFixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalTeams',
            'totalPlayers',
            'totalMatches',
            'upcomingMatches',
            'completedMatches',
            'latestFixtures'
        ));
    }
}