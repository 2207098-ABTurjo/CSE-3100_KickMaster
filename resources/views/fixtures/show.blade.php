@extends('layouts.app')
@section('title', 'Fixture Details')

@section('content')
<a href="{{ route('fixtures.index') }}" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back to Fixtures</a>

<div class="card mb-4">
    <div class="card-body text-center">
        <p class="text-muted">{{ $fixture->match_date->format('d M Y, h:i A') }} &bull; {{ $fixture->venue }}</p>
        <div class="row align-items-center">
            <div class="col-5 text-end"><h4>{{ $fixture->homeTeam->name }}</h4></div>
            <div class="col-2"><span class="badge bg-secondary fs-6">VS</span></div>
            <div class="col-5 text-start"><h4>{{ $fixture->awayTeam->name }}</h4></div>
        </div>
        <span class="badge bg-info mt-2">{{ ucfirst($fixture->status) }}</span>
    </div>
</div>

<div class="card">
    <div class="card-header fw-bold"><i class="bi bi-cloud-sun"></i> Match Day Weather</div>
    <div class="card-body" id="weatherBox" data-venue="{{ $fixture->venue }}">
        <p class="text-muted">Loading weather...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Ei script OpenWeather API theke match venue er weather fetch kore dekhay.
// stadium-to-city mapping banano hoiche
document.addEventListener('DOMContentLoaded', function () {
    const box = document.getElementById('weatherBox');
    const venue = box.dataset.venue || 'London';
    const apiKey = '{{ env('OPENWEATHER_API_KEY') }}';

    // Stadium name -> real city name mapping, jate weather API thik city khuje pay
    const stadiumToCity = {
        'Santiago Bernabeu': 'Madrid',
        'Camp Nou': 'Barcelona',
        'Old Trafford': 'Manchester',
        'Etihad Stadium': 'Manchester',
        'Anfield': 'Liverpool',
        'Allianz Arena': 'Munich',
        'Parc des Princes': 'Paris',
        'Allianz Stadium': 'Turin',
        'San Siro': 'Milan',
        'Stamford Bridge': 'London',
        'Emirates Stadium': 'London',
        'Signal Iduna Park': 'Dortmund',
    };

    const city = stadiumToCity[venue] || venue;

    if (!apiKey) {
        box.innerHTML = '<p class="text-muted mb-0">Weather API key not found</p>';
        return;
    }

    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(city)}&appid=${apiKey}&units=metric`)
        .then(res => res.json())
        .then(data => {
            if (data.main) {
                box.innerHTML = `
                    <p class="mb-1"><strong>${data.weather[0].main}</strong> (${data.weather[0].description})</p>
                    <p class="mb-0">${data.main.temp}&deg;C &bull; Humidity: ${data.main.humidity}% &bull; Wind: ${data.wind.speed} m/s</p>
                    <small class="text-muted">Weather shown for ${city} (nearest city to ${venue})</small>
                `;
            } else {
                box.innerHTML = `<p class="text-muted mb-0">Weather data not found for "${city}".</p>`;
            }
        })
        .catch(() => box.innerHTML = '<p class="text-muted mb-0">There is an issue to load weather data.</p>');
});
</script>
@endsection