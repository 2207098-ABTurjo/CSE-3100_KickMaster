<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

// Ei seeder TheSportsDB free API theke protita team er REAL logo/stadium/country fetch kore.
// Free tier e ekbar e pura league list newa jay na, tai amra ekta ekta kore real team name
// diye search kori (ei method TheSportsDB official tutorial e o dekhano hoyeche, free key e kaj kore).
class TeamSeeder extends Seeder
{
    // TheSportsDB free demo API key - kono signup lage na
    private string $apiKey = '3';

    // Real club name list - protita name diye API te search kora hobe
    private array $realClubNames = [
        'Real Madrid',
        'Barcelona',
        'Manchester United',
        'Manchester City',
        'Liverpool',
        'Bayern Munich',
        'Paris Saint-Germain',
        'Juventus',
        'AC Milan',
        'Chelsea',
        'Arsenal',
        'Borussia Dortmund',
    ];

    public function run(): void
    {
        foreach ($this->realClubNames as $clubName) {
            $teamData = $this->fetchTeamFromApi($clubName);

            // API theke data na paile fallback data use hobe shudhu ei ekta team er jonno
            if (! $teamData) {
                $teamData = $this->fallbackTeam($clubName);
            }

            Team::create($teamData);
        }
    }

    // Ekta specific team name diye TheSportsDB API te search kora hocche
    private function fetchTeamFromApi(string $clubName): ?array
    {
        try {
            $response = Http::timeout(10)->get(
                "https://www.thesportsdb.com/api/v1/json/{$this->apiKey}/searchteams.php",
                ['t' => $clubName]
            );

            if (! $response->successful() || empty($response->json('teams'))) {
                Log::warning("TheSportsDB: no team data returned for {$clubName}");

                return null;
            }

            // Prothom result ta use kora hocche
            $t = $response->json('teams')[0];

            return [
                'name' => $t['strTeam'] ?? $clubName,
                'short_name' => $t['strTeamShort'] ?? strtoupper(substr($clubName, 0, 3)),
                'country' => $t['strCountry'] ?? 'Unknown',
                // Ei duita field e REAL logo url pawa jay
                'logo_url' => $t['strTeamBadge'] ?? $t['strBadge'] ?? null,
                'founded_year' => is_numeric($t['intFormedYear'] ?? null) ? (int) $t['intFormedYear'] : null,
                'stadium' => $t['strStadium'] ?? null,
                'coach_name' => $t['strManager'] ?? 'Not Available',
            ];
        } catch (\Exception $e) {
            Log::warning("TheSportsDB API error for {$clubName}: ".$e->getMessage());

            return null;
        }
    }

    // API completely fail korle ekta basic fallback row create kora hocche
    private function fallbackTeam(string $clubName): array
    {
        return [
            'name' => $clubName,
            'short_name' => strtoupper(substr($clubName, 0, 3)),
            'country' => 'Unknown',
            'logo_url' => 'https://ui-avatars.com/api/?name='.urlencode($clubName).'&background=random&size=128',
            'founded_year' => null,
            'stadium' => null,
            'coach_name' => 'Not Available',
        ];
    }
}