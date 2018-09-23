<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;

class Movie extends Model
{
    protected $table = 'movies';

    public function persons()
    {
        return $this->belongsToMany(Person::class);
    }
}
