@extends('layouts.app')
@section('title', 'Match Statistics')

@section('content')
<h2 class="mb-4"><i class="bi bi-bar-chart"></i> Update Match Statistics</h2>
<p class="text-muted">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</p>

@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@php $s = $match->statistic; @endphp
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('admin.matches.statistics.update', $match) }}">
        @csrf @method('PUT')
        <table class="table">
            <thead><tr><th>{{ $match->homeTeam->short_name }}</th><th class="text-center">Stat</th><th>{{ $match->awayTeam->short_name }}</th></tr></thead>
            <tbody>
                @php
                    $fields = [
                        'possession' => 'Possession (%)',
                        'shots' => 'Shots',
                        'shots_on_target' => 'Shots on Target',
                        'corners' => 'Corners',
                        'fouls' => 'Fouls',
                        'yellow_cards' => 'Yellow Cards',
                        'red_cards' => 'Red Cards',
                    ];
                @endphp
                @foreach($fields as $key => $label)
                    <tr>
                        <td><input type="number" min="0" name="home_{{ $key }}" class="form-control" value="{{ old('home_'.$key, $s->{'home_'.$key} ?? 0) }}"></td>
                        <td class="text-center align-middle">{{ $label }}</td>
                        <td><input type="number" min="0" name="away_{{ $key }}" class="form-control" value="{{ old('away_'.$key, $s->{'away_'.$key} ?? 0) }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Update Statistics</button>
    </form>
</div></div>
@endsection