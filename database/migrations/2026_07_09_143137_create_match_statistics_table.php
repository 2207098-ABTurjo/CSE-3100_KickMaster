<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Match statistics table - ekta match er possession, shots, corners etc thake
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->unique()->constrained('matches')->onDelete('cascade');
            $table->integer('home_possession')->default(50); // percentage
            $table->integer('away_possession')->default(50);
            $table->integer('home_shots')->default(0);
            $table->integer('away_shots')->default(0);
            $table->integer('home_shots_on_target')->default(0);
            $table->integer('away_shots_on_target')->default(0);
            $table->integer('home_corners')->default(0);
            $table->integer('away_corners')->default(0);
            $table->integer('home_fouls')->default(0);
            $table->integer('away_fouls')->default(0);
            $table->integer('home_yellow_cards')->default(0);
            $table->integer('away_yellow_cards')->default(0);
            $table->integer('home_red_cards')->default(0);
            $table->integer('away_red_cards')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_statistics');
    }
};