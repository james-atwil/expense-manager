Expense Manager
===============

A simple web application for recording the expenses.

Requirements
------------

- PHP 8.0 or better
- Composer
- MySQL or MariaDB
- nginx or Apache (not tested yet)

Installation 
------------

- First, download the file and install it to the appropriate directory
- Then, go to the directory where the Expense Manager folder resides.
- Copy the `.env.example` file to `.env`
- In the `.env` file, configure the database accordingly
- Execute the command to install the PHP dependencies: `composer install`
- Run the migration command: `php artisan migrate`
- Run the seeder: `php artisan db:seed`


