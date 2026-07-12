<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

// Ei controller Player er shob CRUD ar view operation handle kore
class PlayerController extends Controller
{
    // Shob player list dekhano, team ar position diye filter kora jay
    public function index(Request $request)
    {
        $query = Player::with(['team', 'statistic']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('team_id')) {
            $query->where('team_id', $request->team_id);
        }

        if ($request->filled('position')) {
            $query->where('position', $request->position);
        }

        $players = $query->orderBy('name')->paginate(12)->withQueryString();
        $teams = Team::orderBy('name')->get();

        return view('players.index', compact('players', 'teams'));
    }

    // Player er details ar statistics dekhano
    public function show(Player $player)
    {
        $player->load(['team', 'statistic']);

        return view('players.show', compact('player'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();

        return view('players.create', compact('teams'));
    }

    // New player database e save kora, sathe statistic row o create kora hoy
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'name' => 'required|string|max:255',
            'position' => 'required|in:Forward,Midfielder,Defender,Goalkeeper',
            'jersey_number' => 'required|integer|min:1|max:99',
            'nationality' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'photo_url' => 'nullable|url',
        ]);

        $player = Player::create($validated);

        // Notun player er jonno statistics row create kora hoy 0 diye
        $player->statistic()->create([
            'matches_played' => 0,
            'goals' => 0,
            'assists' => 0,
            'yellow_cards' => 0,
            'red_cards' => 0,
        ]);

        return redirect()->route('players.index')->with('success', 'Player successfully added!');
    }

    public function edit(Player $player)
    {
        $teams = Team::orderBy('name')->get();

        return view('players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'name' => 'required|string|max:255',
            'position' => 'required|in:Forward,Midfielder,Defender,Goalkeeper',
            'jersey_number' => 'required|integer|min:1|max:99',
            'nationality' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'photo_url' => 'nullable|url',
        ]);

        $player->update($validated);

        return redirect()->route('players.index')->with('success', 'Player successfully updated!');
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return redirect()->route('players.index')->with('success', 'Player deleted successfully!');
    }
}