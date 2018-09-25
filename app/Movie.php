<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;

class Movie extends Model
{
    protected $table = 'movies';

    public function persons()
    {
        return $this->belongsToMany(Person::class)->withPivot('job');
    }

    public function add_person($person, int $job) {
        if ( !(Person::where('name', '=', $person->name)->exists()) ) {
            $person_to_insert = new Person;
            $person_to_insert->name = $person->name;
            $person_to_insert->description = $person->biography;
            $person_to_insert->save();
        }
        $person_inserted = Person::where('name', '=', $person->name)->first();
        $this->persons()->attach($person_inserted, array('job' => $job));
    }

    public function remove_person(int $personId, int $job) {
        $this->persons()->where('id', '=', $personId)->wherePivot('job', $job)->detach($personId);
    }
}
