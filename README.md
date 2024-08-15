1. Project setup:
    composer install
    npm install
    npm run dev
    php artisan serve

2. Migrate database table:
    php artisan migrate

3. Running AdminTableSeeder to populate admins table:
    composer dump-autoload
    php artisan db:seed