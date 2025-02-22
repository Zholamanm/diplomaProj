# Project Setup

This guide will walk you through setting up a backend using Laravel and a frontend using Vue.js.

## Prerequisites

Ensure you have the following installed:
- **Node.js**: `v20.16.0`
- **PHP**: `8.0.30`
- **Composer**: Latest version
- **npm**: Latest version (comes with Node.js)

## Backend (Laravel)

### 1. Install Laravel


1. Navigate to the backend directory:

    ```bash
    cd backend
    ```
2. Install Laravel via Composer:

    ```bash
    composer install
    ```
3. Set up your `.env` file by copying `.env.example`:

    ```bash
    cp .env.example .env
    ```

4. Generate an application key:

    ```bash
    php artisan key:generate
    ```

5. Configure your `.env` file with database credentials, etc.

### 2. Run Migrations

1. Run the following command to set up your database:

    ```bash
    php artisan migrate
    ```
2. Now you can add employees using the command:

    ```bash
    php artisan add:employees
    ```
### 3. Serve the Application

1. Start the Laravel development server:

    ```bash
    php artisan serve
    ```





## Frontend (Vue.js)

### 1. Set Up Vue.js


1. Navigate to the frontend directory:

    ```bash
    cd frontend
    ```

### 2. Install Dependencies

1. Install all necessary dependencies:

    ```bash
    npm install
    ```

### 3. Start the Vue.js Development Server

1. Run the following command to start the frontend development server:

    ```bash
    npm run serve
    ```

## Conclusion

Now, both the Laravel backend and Vue.js frontend should be up and running. The backend runs on `http://localhost:8000`, and the frontend on `http://localhost:8080` (or another port specified by Vue CLI). The Vue frontend proxies API requests to the Laravel backend for a seamless development experience.

To add employees, you can use the custom command:

```bash
php artisan add:employees
