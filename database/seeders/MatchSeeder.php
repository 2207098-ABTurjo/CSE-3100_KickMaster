<?php

namespace Database\Seeders;

use App\Models\GameMatch;
use App\Models\Team;
use Illuminate\Database\Seeder;

// Ei seeder minimum 20 ta completed/live match create kore, sathe statistics o create kore
class MatchSeeder extends Seeder
{
    public function run(): void
    {
        $teams = Team::pluck('id')->all();
        $venues = ['Santiago Bernabeu', 'Camp Nou', 'Old Trafford', 'Etihad Stadium', 'Anfield', 'Allianz Arena', 'Parc des Princes'];

        for ($i = 1; $i <= 20; $i++) {
            $homeTeamId = $teams[array_rand($teams)];
            do {
                $awayTeamId = $teams[array_rand($teams)];
            } while ($awayTeamId === $homeTeamId);

            // Shesh match ta 'live' rakha hocche demo dekhanor jonno, baki shob 'completed'
            $status = $i === 20 ? 'live' : 'completed';

            $match = GameMatch::create([
                'home_team_id' => $homeTeamId,
                'away_team_id' => $awayTeamId,
                'match_date' => now()->subDays(rand(1, 60)),
                'venue' => $venues[array_rand($venues)],
                'home_score' => rand(0, 4),
                'away_score' => rand(0, 4),
                'status' => $status,
            ]);

            // Protita match er jonno statistics create kora hocche
            $homePossession = rand(35, 65);
            $match->statistic()->create([
                'home_possession' => $homePossession,
                'away_possession' => 100 - $homePossession,
                'home_shots' => rand(5, 20),
                'away_shots' => rand(5, 20),
                'home_shots_on_target' => rand(1, 10),
                'away_shots_on_target' => rand(1, 10),
                'home_corners' => rand(0, 12),
                'away_corners' => rand(0, 12),
                'home_fouls' => rand(2, 15),
                'away_fouls' => rand(2, 15),
                'home_yellow_cards' => rand(0, 4),
                'away_yellow_cards' => rand(0, 4),
                'home_red_cards' => rand(0, 1),
                'away_red_cards' => rand(0, 1),
            ]);
        }
    }
}