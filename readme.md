# Movie Library

First things first, edit your .env file at your conveniance. Use your key in **API_MOVIE_KEY**

Install all package

```sh
composer install
npm install
```


Migrate your database

```sh
php artisan migrate
```

## Insert Movie

To insert a movie in the database, run this command:

```sh
php artisan movie:insert '{movie name}'
```

## Visualize pages

First run:

```sh
php -S localhost:8080 -t public
```

Then go on [localhost:8080/movie] to go on the movie list page.

## To Do

* Person pages
* Pagination
* Get image
* Use vue template to make movie cards

## Issues

* Fail to install all npm depencies on ubuntu/microsoft VM
* Cannot use vuejs without npm
* Cannot use npm run prod or dev
