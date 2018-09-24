<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Movie Library</title>
    </head>
    <body>
        <example-component></example-component>
        <h1>{{ $movie->title }}</h1>
        <h3>Release :</h3>
        <p>{{ $movie->release_date }}</p>
        <h3>Synopsis :</h3>
        <p>{{ $movie->description }}</p>
        <h3>Cast :</h3>
        @foreach($movie->persons as $person)
            @if ($person->pivot->job == 1)
                <p>{{ $person->name }}</p>
            @endif
        @endforeach
        <h3>Crew :</h3>
        @foreach($movie->persons as $person)
            @if ($person->pivot->job == 2)
                <p>{{ $person->name }}</p>
            @endif
        @endforeach
    </body>
</html>
