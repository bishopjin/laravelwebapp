
# laravelwebapp
Consolidated laravel web applications

This is the consolidated version of all laravel in this repository. User can register once and access 
all laravel app using only one login credential. 


User can access both admin and non-admin account with only one login account.

##Installation
Clone this project

Go to the folder application using cd command on your cmd or terminal

Run
```
composer install
```
Copy value from .env.example to .env file

Generate key

```
php artisan key:generate
```
Migrate database

```
php artisan migrate
```
Run web server

```
php artisan serve
```
In browser type http://127.0.0.1:8000/
