<?php

namespace App\Http\Controllers;
use App\Movie;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function list() {
        $movies = Movie::all();
        return view('movies.list', compact('movies'));
    }
    public function show(Movie $movie) {
        return view('movies.show', compact('movie'));
    }
}
