## Personal Photos Leaflet Map

Laravel 9 App using Laravel Jetstream and Sail

This CRUD Project also utilizes Livewire and AlpineJs

route ```/map``` contains a leaflet map in which a user can add a photo with corresponding latitude and longitude coordinates which will then add a pin to the map.

Added photos can be edited/updated.

Currently working on adding tests using the in included phpunit.

## Requirements:
Docker

## Installation:
Note to run sail commands run ```alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'```

* Download repo
* Copy/rename ```.env.example``` file to ```.env```
* In terminal navigate to the repo
* Install dependencies, run
    ```
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    ```
* Run ```sail up```
* Run (in new terminal) run ```./vendor/bin/sail shell``` then  ```npm install && npm run dev```
* Run (in new terminal) run ```./vendor/bin/sail shell``` then  ```php artisan storage:link```
* Open browser, navigate to localhost
* Click "generate app key", refresh page
* Click "run migrations", refresh page
* Register as new user
* Vavigate to ```localhost/map```

* To run tests (in new terminal) run ```./vendor/bin/sail shell``` then  ```php artisan test```

### Troubleshooting:
* If port 80 error - Ensure mysql is not already running
* To remove all docker images and volumesr run ./vendor/bin/sail down --rmi all -v
