## Step 1: Configure Database
Create an empty MySQL 8.x database

## Step 2: Configure Environment Variables
Change the corresponing settings in the provided .env file:
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apiapp
DB_USERNAME=apiapp
DB_PASSWORD=apiapp
```
Copy the provided environment file to the root directory.

## Step 3: Install Dependencies
Go to project root directory & execute:
```sh
composer install
```

## Step 4: Apply database migrations
Run the following command to apply DB migrations:
```sh
php artisan migrate
```

## Running Tests
To execute the test suite, run:
```sh
php artisan test
```
