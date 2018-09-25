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

    public function update(Request $request, Movie $movie) {
        $request->validate([
            'title' => 'unique:movies|min:1|max:50',
            'description' => 'min:10|max:400',
            'release_date' => 'date',
        ]);
        // We should also validate add_actor, add_crew, remove_actor & remove_crew
        $userInput = $request->all();
        foreach($userInput as $ressource => $value) {
            if ( isset( $movie[$ressource] ) ) {
                $movie[$ressource] = $value;
            } elseif ( $ressource === 'add_actor') {
                foreach (json_decode($value) as $person) {
                    $movie->add_person($person, 1);
                }
            } elseif ( $ressource === 'remove_actor') {
                foreach (json_decode($value) as $person) {
                    $movie->remove_person($person->id, 1);
                }
            } elseif ( $ressource === 'add_crew') {
                foreach (json_decode($value) as $person) {
                    $movie->add_person($person, 2);
                }
            } elseif ( $ressource === 'remove_crew') {
                foreach (json_decode($value) as $person) {
                    $movie->remove_person($person->id, 2);
                }
            }
        }
        $movie->save();
        return json_encode($movie);
    }
}
