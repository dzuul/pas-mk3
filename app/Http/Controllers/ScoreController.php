<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{


public function saveScore(Request $request)
{
    $score = new Score();
    $score->username = $request->username;
    $score->game = $request->game;
    $score->score = $request->score;
    $score->save();
}

}
