<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Http\Request;

// Ei controller Fixture (upcoming match schedule) er CRUD handle kore
class FixtureController extends Controller
{
    // Home page e upcoming fixture gula dekhano hoy (public)
    public function home()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->take(6)
            ->get();

        return view('welcome', compact('fixtures'));
    }

    // Shob fixture list, status ar date diye filter kora jay
    public function index(Request $request)
    {
        $query = Fixture::with(['homeTeam', 'awayTeam']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('match_date', $request->date);
        }

        $fixtures = $query->orderBy('match_date')->paginate(10)->withQueryString();

        return view('fixtures.index', compact('fixtures'));
    }

    // Fixture details ar match day weather dekhano (external API diye)
    public function show(Fixture $fixture)
    {
        $fixture->load(['homeTeam', 'awayTeam']);

        return view('fixtures.show', compact('fixture'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();

        return view('fixtures.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date|after:now',
            'venue' => 'nullable|string|max:255',
        ]);

        $validated['status'] = 'scheduled';

        Fixture::create($validated);

        return redirect()->route('fixtures.index')->with('success', 'Fixture successfully created!');
    }

    public function edit(Fixture $fixture)
    {
        $teams = Team::orderBy('name')->get();

        return view('fixtures.edit', compact('fixture', 'teams'));
    }

    public function update(Request $request, Fixture $fixture)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $fixture->update($validated);

        return redirect()->route('fixtures.index')->with('success', 'Fixture successfully updated!');
    }

    public function destroy(Fixture $fixture)
    {
        $fixture->delete();

        return redirect()->route('fixtures.index')->with('success', 'Fixture deleted successfully!');
    }
}