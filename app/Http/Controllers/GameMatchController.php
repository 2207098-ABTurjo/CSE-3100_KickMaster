<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Http\Request;

// Ei controller Match (result, live score) er CRUD ar score update handle kore
class GameMatchController extends Controller
{
    // Shob match list, team ar status diye filter kora jay
    public function index(Request $request)
    {
        $query = GameMatch::with(['homeTeam', 'awayTeam']);

        if ($request->filled('team_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('home_team_id', $request->team_id)
                    ->orWhere('away_team_id', $request->team_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $matches = $query->orderBy('match_date', 'desc')->paginate(10)->withQueryString();
        $teams = Team::orderBy('name')->get();

        return view('matches.index', compact('matches', 'teams'));
    }

    // Match details, score ar statistics shoho dekhano
    public function show(GameMatch $match)
    {
        $match->load(['homeTeam', 'awayTeam', 'statistic']);

        return view('matches.show', compact('match'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();

        return view('matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,live,completed',
        ]);

        $validated['home_score'] = 0;
        $validated['away_score'] = 0;

        $match = GameMatch::create($validated);

        // Notun match er jonno statistics row create kora hoy default value diye
        $match->statistic()->create([
            'home_possession' => 50,
            'away_possession' => 50,
        ]);

        return redirect()->route('matches.index')->with('success', 'Match successfully created!');
    }

    public function edit(GameMatch $match)
    {
        $teams = Team::orderBy('name')->get();

        return view('matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, GameMatch $match)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|in:upcoming,live,completed',
        ]);

        $match->update($validated);

        return redirect()->route('matches.index')->with('success', 'Match successfully updated!');
    }

    public function destroy(GameMatch $match)
    {
        $match->delete();

        return redirect()->route('matches.index')->with('success', 'Match deleted successfully!');
    }

    // Ei function AJAX request diye live score update kore (button click e call hoy)
    public function updateScore(Request $request, GameMatch $match)
    {
        $validated = $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'status' => 'required|in:upcoming,live,completed',
        ]);

        $match->update($validated);

        // AJAX call theke asle JSON response ferot dei
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Score updated!',
                'home_score' => $match->home_score,
                'away_score' => $match->away_score,
                'status' => $match->status,
            ]);
        }

        return back()->with('success', 'Score successfully updated!');
    }
}