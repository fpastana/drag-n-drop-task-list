# About the App

This app creates a Task List bound to a project (the list of projects comes from a Laravel Database Seeder) where you can drag and drop the elements of the table to update the items priority as well as add, update and delete tasks to any Laravel supported database.

## Technology Stack

- [Laravel v10.x](https://laravel.com): This is a PHP MVC Framework.
- [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript): JavaScript (JS) is a lightweight, interpreted, or just-in-time compiled programming language with first-class functions
- [Bootstrap 5.3.0](https://getbootstrap.com/docs/5.3/getting-started/introduction/): Bootstrap is a powerful, feature-packed frontend toolkit
- [Touch Table Row Sorter](https://www.jqueryscript.net/table/touch-table-row-sorter.html): Touch-enabled Drag'n'drop Table Sorter - RowSorter.js
- [Feather Icons v4.29.0](https://feathericons.com): Simply beautiful open source icons
- [Sweet Alert 1.X](https://sweetalert.js.org/guides/): A beautiful replacement for JavaScript's "alert"
- [MYSQL Ver 8.0.32](https://www.mysql.com/): MySQL a Relational Database

# System Requirements

-   PHP v8.1 
-   Composer
-   Any Laravel supported database
-   JavaScript
-   As the current version is built on Laravel v10.x, all requirements of this version of Laravel MUST be met [as stated here](https://laravel.com/docs/10.x/deployment#server-requirements).

# Setting up the Dev Environment

-   Inside the application folder, copy the `.env.example` file to `.env`

```
cp .env.example .env
```

-   Open the `.env` file and set your local environment variables such as `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

-   Install the composer packages:

```
# composer install
```

- Run the migration and seed commands

```
# php artisan migrate --seed
``` 

- Run the PHP/Laravel server

```
# php artisan serve 
```

***For tutorials on how to build Open Source Apps, please go to [felipepastana.com](https://felipepastana.com)***

