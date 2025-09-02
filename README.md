# Laravel Portfolio

A modern, customizable portfolio website built with Laravel, designed for developers and creatives to showcase their work, skills, and professional information.

## Features

-   **Responsive Design**: Fully responsive layout that works on all devices
-   **Project Showcase**: Display your projects with categories, images, and descriptions
-   **Skills Section**: Highlight your technical and professional skills
-   **About Me**: Customizable section to share your professional background
-   **Contact Form**: Allow visitors to reach out to you directly
-   **Theme Customization**: Personalize colors and styling through the admin panel
-   **Admin Dashboard**: Secure area to manage all content
-   **SEO Friendly**: Optimized for search engines

## Requirements

-   PHP 8.2 or higher
-   MySQL 5.7 or higher
-   Composer
-   Node.js and NPM

## Installation

1. Clone the repository

    ```bash
    git clone https://github.com/shayanahmad1999/laravel-portfolio.git
    cd laravel-portfolio
    ```

2. Install PHP dependencies

    ```bash
    composer install
    ```

3. Install and compile frontend assets

    ```bash
    npm install
    npm run dev
    ```

4. Create and configure your environment file

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. Configure your database in the `.env` file

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_portfolio
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. Run database migrations and seed demo data

    ```bash
    php artisan migrate
    php artisan db:seed --class=DemoSeeder
    ```

7. Start the development server
    ```bash
    php artisan serve
    ```

## Admin Access

After seeding the database, you can access the admin panel at `/admin` with the following credentials:

-   Email: admin@example.com
-   Password: password

## Customization

### Site Settings

From the admin panel, you can customize:

-   Site title and description
-   Contact information
-   Social media links
-   Theme colors (primary, secondary, accent, etc.)

### About Information

Manage your professional information including:

-   Profile image
-   Professional title
-   Biography
-   Experience statistics
-   Resume link

### Projects and Skills

Add, edit, and categorize your projects and skills through the admin interface.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
