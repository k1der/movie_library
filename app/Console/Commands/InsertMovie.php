<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Movie;
use App\Person;

class InsertMovie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:insert {movie_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a movie from the movie db in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Find the movie by name.
     *
     * @return mixed
     */
    public function find_movie_by_name($name) {
        $endpoint = env('API_MOVIE_URL').'search/movie';
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET',
            $endpoint,
            [
                'query' => [
                    'api_key' => env('API_MOVIE_KEY'),
                    'query' => str_replace('', '+', $name)
                ]
            ]
        );
        return json_decode($response->getBody(), true)['results'];
    }

    /**
     * Find the movie by id.
     *
     * @return mixed
     */
    public function find_movie_by_id($id) {
        $endpoint = env('API_MOVIE_URL').'movie/'.$id;
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET',
            $endpoint,
            [
                'query' => [
                    'api_key' => env('API_MOVIE_KEY'),
                    'append_to_response' => "credits"
                ]
            ]
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * Find the person by id.
     *
     * @return mixed
     */
    public function find_person_by_id($id) {
        $endpoint = env('API_MOVIE_URL').'person/'.$id;
        $client = new \GuzzleHttp\Client();
        $response = $client->request(
            'GET',
            $endpoint,
            [
                'query' => [
                    'api_key' => env('API_MOVIE_KEY')
                ]
            ]
        );
        return json_decode($response->getBody(), true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $movie_name = $this->argument('movie_name');
        $this->info('Movie Name : '.$movie_name);

        $list = $this->find_movie_by_name($movie_name);

        foreach ($list as $result) {
            if ($this->confirm('Do you wish to insert '.$result['title'].'?')) {
                $this->info('Try to insert : '.$result['title']);

                $movie_details = $this->find_movie_by_id($result['id']);

                $this->info('Release Date : '.$movie_details['release_date']);
                $this->info('Description : '.$movie_details['overview']);
                $this->info('Cast :'.count($movie_details['credits']['cast']));
                $this->info('Crew :'.count($movie_details['credits']['crew']));
                // Check if movie exist in db
                if ( !(Movie::where('title', '=', $result['title'])->exists()) ) {
                    $movie_to_insert = new Movie;
                    $movie_to_insert->title = $result['title'];
                    $movie_to_insert->release_date = $movie_details['release_date'];
                    $movie_to_insert->description = $movie_details['overview'];
                    $movie_to_insert->save();
                }
                $movie = Movie::where('title', '=', $result['title'])->first();
                foreach ($movie_details['credits']['cast'] as $actor) {
                    $actor_detail = $this->find_person_by_id($actor['id']);
                    if ( !(Person::where('name', '=', $actor['name'])->exists()) ) {
                        $person_to_insert = new Person;
                        $person_to_insert->name = $actor['name'];
                        $person_to_insert->description = $actor_detail['biography'];
                        $person_to_insert->save();
                    }
                    $person = Person::where('name', '=', $actor['name'])->first();
                    $movie->persons()->attach($person, array('as' => 1));
                }
                foreach ($movie_details['credits']['crew'] as $member) {
                    $member_detail = $this->find_person_by_id($member['id']);
                    if ( !(Person::where('name', '=', $member['name'])->exists()) ) {
                        $person_to_insert = new Person;
                        $person_to_insert->name = $member['name'];
                        $person_to_insert->description = $member_detail['biography'];
                        $person_to_insert->save();
                    }
                    $person = Person::where('name', '=', $member['name'])->first();
                    $movie->persons()->attach($person, array('as' => 2));
                }
                break;
            } else {
                continue;
            }
        }
    }
}
