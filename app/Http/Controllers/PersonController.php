<?php

namespace App\Http\Controllers;
use App\Person;

use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function list() {
        $persons = Person::all();
        return json_encode($persons);
    }
    public function show(Person $person) {
        return json_encode($person);
    }
}
