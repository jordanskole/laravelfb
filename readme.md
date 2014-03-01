## Laravel FB Login Quickstart

This repo is a quick way to spin up a simple laravel application using fb login for user registration & management. It is meant to be deployed on the [pagodabox](https://pagodabox.com/) PaaS. It uses bootstrap, font-awesome, and Jeffery Way's laravel generators.

### Getting Started

#### Spin up Laravel using composer

1. clone this repo into your working directory. 
2. Run `composer install`
3. Run `composer update`

#### Setup a db & migrate

1. Create a new mysql db and user.
2. Replace my default db credentials in `/app/config/database.php`
3. Run `php artisan migrate` from your working directory.

#### Setup fb application

1. Head to [developers.fb.com](https://developers.facebook.com/) and create a new application
2. Set your app domains to use your new domains (inside your app settings on dev.fb.com)
3. Replace my dummy credentials in `app/config/facebook.php`

#### Optional Install Bower 

1. Install [node.js & npm](http://nodejs.org/)
2. Install Bower - `npm install -g bower`
3. Explain to be how to use Bower & Grunt. 
