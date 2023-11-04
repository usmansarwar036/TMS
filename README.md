## About Task Mangemnent System

The system will allow users to create, edit, delete, and mark tasks as completed. Users will also be able to view a list of tasks and filter them by their completion status.

## System installation

1.  Copy <b>.env.example</b> to <b>.env</b>
2.  Create a database
3.  Edit database name in <b>.env</b>
4.  Create App key

```bash
php artisan key:generate
```

5. Install Composer Modules

```bash
composer install
```

6. Migrate Database file to database

```bash
php artisan migrate
```

7. Serve project in browser

```bash
php artisan serve
```
