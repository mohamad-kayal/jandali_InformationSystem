# Jandali Information System

Jandali Information System is a PHP/MySQL point-of-sale and inventory management application for Jandali Co. It supports daily shop operations such as managing clients, suppliers, inventory, purchase carts, sales carts, invoices, returns, payments, balances, and dashboard reporting.

## Features

- User login with password hashing for new and upgraded accounts
- Client and supplier records with balances and contact details
- Item catalog with pricing, stock, brand, size, material, and origin fields
- Purchase and sales cart workflows
- Purchase, sales, proforma, and return invoice pages
- Balance updates and payment tracking
- Daily, weekly, monthly, and yearly report templates
- Dashboard charts for income, expenditures, sold items, and purchased items
- Environment-based database configuration through `.env`

## Requirements

- PHP 7.4 or newer
- MySQLi PHP extension
- MySQL or MariaDB
- Apache, Nginx, or the PHP built-in development server

## Project structure

| Path | Purpose |
| --- | --- |
| `index.php` | Login entry point |
| `dashboard.php` | Main dashboard and charts |
| `connection.php` | Database connection and local `.env` loading |
| `functions.php` / `helpers.php` | Shared PHP functions and request helpers |
| `database_schema.sql` | Starter database schema inferred from the application |
| `.env.example` | Template for local database configuration |
| `invoice_templates.php` / `html_templates.php` | Reusable page and invoice markup |
| `css/`, `images/`, `DataTables/` | Asset directories expected by the UI |

## Setup

1. Copy the environment template:

   ```bash
   cp .env.example .env
   ```

2. Update `.env` with your local database settings:

   ```dotenv
   DB_HOST=localhost
   DB_PORT=3306
   DB_USER=jandali_user
   DB_PASS=change_me
   DB_NAME=pos
   APP_ENV=production
   ```

   Use `APP_ENV=development` only on a local machine if you need detailed database connection errors.

3. Create the database and import the starter schema:

   ```bash
   mysql -u your_user -p < database_schema.sql
   ```

   Review `database_schema.sql` before using it with production data. It is a starting schema inferred from the PHP files and may need adjustments for an existing database.

4. Serve the repository from a PHP-enabled web server document root.

   For local development, you can use:

   ```bash
   php -S localhost:8000
   ```

5. Open `http://localhost:8000/index.php` and sign in with a user record from your database.

## Validation

Run PHP syntax validation across the root PHP files:

```bash
find . -maxdepth 1 -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Security notes

- Do not commit `.env`, database dumps with private data, or real credentials.
- Keep `APP_ENV=production` outside local development so database errors are not shown to users.
- New and updated user passwords are hashed. Reset or upgrade any legacy plain-text user passwords before production use.
- Some legacy endpoints still need additional hardening, including full prepared-statement coverage, CSRF protection, and authorization checks.
- Review file upload and asset directories before enabling uploads in production.

## Known limitations

- Several UI files reference assets under `css/`, `Images/`, `images/`, and `DataTables/`; make sure the required files are restored or replaced before deployment.
- The application is a legacy page-based PHP app without an automated test suite in this repository.
- The database schema is provided as a baseline and should be checked against real production data before migration.
