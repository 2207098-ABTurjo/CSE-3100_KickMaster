<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

// Ei controller Team er shob CRUD operation handle kore
class TeamController extends Controller
{
    // Shob team list dekhano (pagination shoho)
    public function index(Request $request)
    {
        $query = Team::withCount('players');

        // Search kora hole name diye filter hobe
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $teams = $query->orderBy('name')->paginate(9)->withQueryString();

        return view('teams.index', compact('teams'));
    }

    // Ekta team er details dekhano
    public function show(Team $team)
    {
        $team->load('players');

        return view('teams.show', compact('team'));
    }

    // Admin er jonno new team create form
    public function create()
    {
        return view('teams.create');
    }

    // New team database e save kora
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'short_name' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url',
            'founded_year' => 'nullable|digits:4|integer|min:1800|max:'.date('Y'),
            'stadium' => 'nullable|string|max:255',
            'coach_name' => 'nullable|string|max:255',
        ]);

        Team::create($validated);

        return redirect()->route('teams.index')->with('success', 'Team successfully added!');
    }

    // Edit form dekhano
    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    // Update kora existing team
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,'.$team->id,
            'short_name' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url',
            'founded_year' => 'nullable|digits:4|integer|min:1800|max:'.date('Y'),
            'stadium' => 'nullable|string|max:255',
            'coach_name' => 'nullable|string|max:255',
        ]);

        $team->update($validated);

        return redirect()->route('teams.index')->with('success', 'Team successfully updated!');
    }

    // Team delete kora (players o cascade delete hobe migration er জন্য)
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }
}