<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{!! asset('css/app.css') !!}" media="all" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

        <title>Movie Library</title>
    </head>
    <body>
        <div id="movies-list" class="col-md-12">
            <h1>Movie List</h1>
            <input class="search" placeholder="Search a movie" />
            <ul class="list">
                @foreach( $movies as $movie )
                    <li><a class="title" href="{!! route('movie.show', ['movie'=>$movie->id]) !!}">{{ $movie->title }}<a></li>
                @endforeach
            </ul>
        </div>
        <script>
            const options = {
                valueNames: [ 'title' ],
            };

            const moviesList = new List('movies-list', options);
        </script>
    </body>
</html>
