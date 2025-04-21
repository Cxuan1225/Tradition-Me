# TraditionMe

TraditionMe is a Laravel-based project that been develop as my final year project during degree.

## Requirements

-   PHP >= 8.2
-   Composer
-   Laravel >= 12.x
-   MySQL or any other supported database

## Installation

1.  Clone the repository:

    ```bash
    git clone https://github.com/your-repo/traditionme.git
    cd traditionme
    ```

2.  Install dependencies:

    ```bash
    composer install
    ```

3.  Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    3.1. Update your Stripe secret and webhook key in the `.env` file:

        ```env
        STRIPE_SECRET=your_stripe_secret_key
        STRIPE_WEBHOOK_SECRET=your_stripe_webhook_key
        ```

4.  Generate the application key:

    ```bash
    php artisan key:generate
    ```

5.  Configure your database in the `.env` file.

6.  Run migrations:

    ```bash
    php artisan migrate
    ```

7.  Seed the database:

    ```bash
    php artisan db:seed --class=UserSeeder
    php artisan db:seed --class=ProductSeeder
    ```

8.  Start the development server:
    ```bash
    php artisan serve
    ```

## Usage

-   Access the application at `http://localhost:8000`.
