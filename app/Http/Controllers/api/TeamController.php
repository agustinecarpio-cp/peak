<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teams\TeamNamesResource;
use App\Models\Team;

class TeamController extends Controller
{
    public function names()
    {
        $teams = Team::all();
        return TeamNamesResource::collection($teams);
    }
}
