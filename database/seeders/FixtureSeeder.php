<?php

namespace Database\Seeders;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Database\Seeder;

// Ei seeder upcoming fixture (future date) create kore
class FixtureSeeder extends Seeder
{
    public function run(): void
    {
        $teams = Team::pluck('id')->all();
        $venues = ['Santiago Bernabeu', 'Camp Nou', 'Old Trafford', 'Etihad Stadium', 'Anfield', 'Allianz Arena'];

        for ($i = 1; $i <= 10; $i++) {
            // Duita alada random team select kora hocche
            $homeTeamId = $teams[array_rand($teams)];
            do {
                $awayTeamId = $teams[array_rand($teams)];
            } while ($awayTeamId === $homeTeamId);

            Fixture::create([
                'home_team_id' => $homeTeamId,
                'away_team_id' => $awayTeamId,
                'match_date' => now()->addDays(rand(1, 30))->setTime(rand(15, 21), 0),
                'venue' => $venues[array_rand($venues)],
                'status' => 'scheduled',
            ]);
        }
    }
}