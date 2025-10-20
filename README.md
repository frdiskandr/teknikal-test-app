# teknikal-test-app

This is a Laravel project.

## Getting Started

### Prerequisites

*   PHP
*   Composer
*   Node.js
*   NPM
*   A database sqlite

### Installation

1.  Clone the repository:
    ```bash
    git clone https://github.com/frdiskandr/teknikal-test-app.git
    ```
2.  Navigate to the project directory:
    ```bash
    cd teknikal-test-app
    ```
3.  Install PHP dependencies:
    ```bash
    composer install
    ```
4.  Install NPM dependencies:
    ```bash
    npm install
    ```
5.  Create a copy of the `.env.example` file and name it `.env`:
    ```bash
    cp .env.example .env
    ```
6.  Generate an application key:
    ```bash
    php artisan key:generate
    ```
7.  Configure your database credentials in the `.env` file.

### Database Migration

Run the following command to migrate the database and seed it with initial data:

```bash
php artisan migrate --seed
```

### Running the Development Server

You can start the development server using the following command:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.
