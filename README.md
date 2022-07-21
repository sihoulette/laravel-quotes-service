<h1 align="center">Laravel quotes</h1>

## Introduction
This project is the result of a test task. Please follow the installation instructions

## Installation
- Clone repository to project root ```git clone git@github.com:sihoulette/laravel.quotes.git .```
- Install composer dependencies ```composer install```
- Configure you DB connection
- Generate your application encryption key ```php artisan key:generate```
- Run database migrations ```php artisan migrate```
- Run database seeders ```php artisan db:seed```
- Install npm dependencies ```npm install```
- Build frontend assets ```npm run prod```
- Create encryption keys & clients tokens ```php artisan passport:install```

## Setup queue
Don't forget to instruct your application to use the database driver by updating the QUEUE_CONNECTION variable in your application's .env file:
>```QUEUE_CONNECTION=database```

## Demo access
- Email: ```demo@gmail.com```
- Password: ```password```

## Console commands
- Create new user ```php artisan make:user {name} {email} {password}```
