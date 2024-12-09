<?php

// In app/Http/Controllers/LeaderboardController.php
namespace App\Http\Controllers;

use App\Models\Score; // assuming you have a Score model
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Score;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Fetch the top 10 scores, ordered by score (ascending)
        $scores = Score::orderBy('score', 'asc')->take(10)->get();

        return view('scores', compact('scores'));
    }
    public function showScores()
{
    $scores = Score::all();
    return view('scores', compact('scores'));
}

}
