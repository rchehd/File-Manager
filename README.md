

## How to start

Install PHP 8.3, Composer 2, Docker, Git

1. Pull the project
2. In root directory run `composer install`
3. Copy the file `.env.example` to `.env`
4. Run `php artisan sail:install`
5. Run `./vendor/bin/sail up -d`
5. Run `./vendor/bin/sail artisan make:migration`
6. Go to `http://localhost`


How to test:

1. Go to `http://localhost`
2. Click "Add file"
3. Add files
4. Click -"Back to the files"
5. Click "Delete" on each of file
6. Run command - `./vendor/bin/sail artisan queue:work --queue=send_email`

7. To delete expired files automatically - run command `./vendor/bin/sail artisan files:delete-expired`

RebbitMQ link - `http://localhost:5672` or `http://localhost:15672`

Mailpit link - `http://localhost:1025`
