# Sound Board

This is play project. It is intended to be an API to allow users to create a sound board. This and The frontend React app is a WIP.

Users don't sign in with email. Instead I decided to just let them create a username and set a password. If they forget their password then they'll need to make a new user.

### TODO

- Make all sound clips globally searchable, regardless of who uploaded them.
- Allow anyone to add any uploaded sound clips to their sound board.
- Add S3 support for storing audio files.
- Automatically deactivate user accounts that haven't logged in recently.

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
