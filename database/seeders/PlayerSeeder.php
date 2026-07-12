<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Ei seeder TheSportsDB API theke REAL player name/photo fetch kore protita team er jonno.
// Match statistics (goals, assists etc) free API te paoa jay na, tai shegula simulate kora hocche.
class PlayerSeeder extends Seeder
{
    private string $apiKey = '3';

    private array $positions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];

    private array $nationalities = ['Spain', 'England', 'France', 'Brazil', 'Argentina', 'Germany', 'Portugal', 'Italy', 'Netherlands', 'Belgium'];

    public function run(): void
    {
        $teams = Team::all();

        foreach ($teams as $team) {
            // Protita team er real player list API theke fetch kora hocche
            $apiPlayers = $this->fetchPlayersFromApi($team->name);

            if (! empty($apiPlayers)) {
                $this->seedFromApi($team, $apiPlayers);
            } else {
                // API theke player na paile fallback random player create kora hobe
                $this->seedFallback($team);
            }
        }
    }

    // TheSportsDB theke ekta team er real player list ana hocche
    private function fetchPlayersFromApi(string $teamName): array
    {
        try {
            $response = Http::timeout(10)->get(
                "https://www.thesportsdb.com/api/v1/json/{$this->apiKey}/searchplayers.php",
                ['t' => $teamName]
            );

            if (! $response->successful() || empty($response->json('player'))) {
                return [];
            }

            // Free API onek shomoy 20-25+ player dey, amra max 10 jon rakhchi
            return collect($response->json('player'))->take(10)->toArray();
        } catch (\Exception $e) {
            Log::warning("TheSportsDB player fetch failed for {$teamName}: ".$e->getMessage());

            return [];
        }
    }

    // Real API data diye player ar statistics create kora hocche
    private function seedFromApi(Team $team, array $apiPlayers): void
    {
        $jersey = 1;

        foreach ($apiPlayers as $p) {
            $player = Player::create([
                'team_id' => $team->id,
                'name' => $p['strPlayer'] ?? fake()->firstName().' '.fake()->lastName(),
                // API er position label onno rokom hote pare, tai simple map kora hocche
                'position' => $this->mapPosition($p['strPosition'] ?? null),
                // Free API te jersey number onek shomoy fakhali thake, tai auto-increment kora hocche
                'jersey_number' => is_numeric($p['strNumber'] ?? null) ? (int) $p['strNumber'] : $jersey,
                'nationality' => $p['strNationality'] ?? $this->nationalities[array_rand($this->nationalities)],
                'date_of_birth' => $p['dateBorn'] ?? fake()->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
                'photo_url' => $p['strCutout'] ?? $p['strThumb'] ?? 'https://ui-avatars.com/api/?name='.urlencode($p['strPlayer'] ?? 'Player'),
            ]);

            $jersey++;

            // Stats free API te nai, tai realistic range diye simulate kora hocche
            $this->createRandomStats($player);
        }
    }

    // API fail korle age er moto random player create kora hocche (fallback)
    private function seedFallback(Team $team): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $player = Player::create([
                'team_id' => $team->id,
                'name' => fake()->firstName().' '.fake()->lastName(),
                'position' => $this->positions[array_rand($this->positions)],
                'jersey_number' => $i,
                'nationality' => $this->nationalities[array_rand($this->nationalities)],
                'date_of_birth' => fake()->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
                'photo_url' => 'https://ui-avatars.com/api/?name='.urlencode($team->short_name.$i).'&background=random',
            ]);

            $this->createRandomStats($player);
        }
    }

    // Ei function player er statistics random kintu realistic range e create kore
    private function createRandomStats(Player $player): void
    {
        $matchesPlayed = rand(5, 30);

        $player->statistic()->create([
            'matches_played' => $matchesPlayed,
            'goals' => rand(0, 20),
            'assists' => rand(0, 15),
            'yellow_cards' => rand(0, 8),
            'red_cards' => rand(0, 2),
        ]);
    }

    // API er free-text position ke amader 4 category te map kora hocche
    private function mapPosition(?string $apiPosition): string
    {
        if (! $apiPosition) {
            return $this->positions[array_rand($this->positions)];
        }

        $apiPosition = strtolower($apiPosition);

        return match (true) {
            str_contains($apiPosition, 'keeper') => 'Goalkeeper',
            str_contains($apiPosition, 'back') || str_contains($apiPosition, 'defend') => 'Defender',
            str_contains($apiPosition, 'mid') => 'Midfielder',
            str_contains($apiPosition, 'forward') || str_contains($apiPosition, 'wing') || str_contains($apiPosition, 'striker') => 'Forward',
            default => $this->positions[array_rand($this->positions)],
        };
    }
}