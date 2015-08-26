# BringIt

You Order, We Bring It. Food, groceries, cleaning, laundry, all right to you.

## Requirements

Refer to _composer.json_ for PHP requirements

* Composer (https://getcomposer.org)

A pre-defined database is required, this project *does NOT* create one for you!

## Dependencies

- Facebook for social login (https://developers.facebook.com)
- Mandrill for email (https://mandrillapp.com)
- Stripe for credit card processing (https://developers.facebook.com)
- (optional) Heroku for deployment (https://www.heroku.com)

## Getting Started

Install requirements (from _composer.json_):

        composer update

Configure environment (and modify `.env`):

        cp .env.example .env

Run [database migrations](http://laravel.com/docs/migrations)

        php artisan migrate

## Lumen Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).
