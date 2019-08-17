# Sound Board

This project is intended to be an api to allow users to create a sound board

## Init

1. Pull repo
2. Run `composer install`
3. Run `cp .env.example .env`
4. Edit all database related env variables appropriately
5. Create database
6. Run `php artisan migrate`
7. Run `php artisan serve`

## Testing

`phpunit` runs tests if you have phpunit installed globally with composer.

Otherwise run `./vendor/bin/phpunit`
