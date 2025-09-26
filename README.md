Order Management System

A simple Order Management System built with Laravel, PHP, and MySQL. The system is designed to manage customers, products, and orders with role-based access control, caching, and a clean repository design pattern.

Features

Authentication:

User registration, login, and logout using Laravel Breeze.

Role-based access with Admin and Staff roles, making it easy to add new roles in the future.

Customer Management:

CRUD operations (Create, Read, Update, Delete) for managing customers.

Search/filter customers by name or email.

Product Management:

CRUD operations for managing products (name, price, stock quantity).

Pagination of product listings for easy browsing.

Order Management:

Create orders by selecting customers and products.

Automatically reduce product stock after an order is placed.

View all orders with details (customer name, items ordered, total amount).

Cancel or delete orders with optional restock functionality.

Role-Based Access:

Admin and staff roles with Spatie Laravel Permission for easy management of roles and permissions.

Future-proof design to allow easy addition of new roles and permissions.

Caching:

Optimized system with caching implemented for faster performance when retrieving product and customer data.

Reporting:

Simple dashboard displaying total orders, total revenue, and top 5 customers.

Requirements

PHP 8.1+

Laravel 10+

MySQL or MariaDB

Composer

Installation
1. Clone the repository:
git clone https://github.com/muhmedd-essam/order-management-system/tree/master
cd order-management-system

2. Install dependencies:
composer install

3. Set up your environment file:

Copy .env.example to .env and configure the database connection:

cp .env.example .env


Update .env with your database credentials and other environment variables.

4. Run migrations:
php artisan migrate --seed

5. Start the local development server:
php artisan serve

6. Access the application:

Open your browser and navigate to http://localhost:8000

Admin Credentials

Email: admin@example.com

Password: password



staff Credentials

Email: staff@example.com

Password: password



Database Dump

If you need to import the database, you can download the SQL dump from this link
 or use the provided seeders to populate the database.

Folder Structure

/app: Contains the application logic (models, controllers, etc.)

/database/migrations: Contains the database migrations for creating tables.

/database/seeders: Contains the seeders for populating initial data.

.env.example: Example environment file with placeholder values.

README.md: This file.

/repositories: Directory containing repositories for each entity (Customer, Product, Order).

/config/permission.php: Configuration file for managing roles and permissions using Spatie Laravel Permission.

Contributing

If you'd like to contribute to this project, feel free to fork the repository and submit a pull request.