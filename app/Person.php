<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Movie;

class Person extends Model
{
    protected $table = 'persons';

    public function movies()
    {
        return $this->belongsToMany(Movie::class)->withPivot('job');
    }
}
