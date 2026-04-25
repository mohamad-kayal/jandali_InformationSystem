# Jandali Information System

A PHP/MySQL point-of-sale and inventory system for Jandali Co. It supports supplier and client management, item inventory, sales and purchase carts, invoices, returns, payments, and dashboard reporting.

## Current system analysis

### What is working well
- The application covers the main business processes: clients, suppliers, inventory, selling, purchasing, returns, balances, and reporting.
- The UI flow is simple and page based, which makes it easy to deploy on a standard PHP/Apache stack.
- Sales and purchase carts are separated by user, which is a good base for multi-user operation.

### What was missing or fragile
- No project README, database setup notes, or environment configuration template.
- Database credentials were hardcoded in `connection.php`.
- Several AJAX endpoints built SQL directly from request data and echoed unescaped values.
- New users were saved with plain-text passwords.
- `save_edit_row_from_cart.php` contained invalid PHP text, so syntax validation failed.
- Referenced assets such as `css/`, `Images/`, and `DataTables/` are not present in this repository and must be restored or replaced with CDN/local assets before a full UI deployment.

### Improvements included in this revamp
- Added `.env.example` and `.gitignore` so local credentials do not need to be committed.
- Updated database connection loading to read environment variables or a local `.env` file.
- Added `helpers.php` with shared escaping, request parsing, and prepared-statement helpers.
- Converted critical client/supplier/item create/edit/delete endpoints and invoice-return lookups to prepared statements.
- Escaped dynamic HTML output in the updated endpoints.
- Fixed the broken cart-row save endpoint and restricted it to known cart tables.
- Updated login/new-user handling to use password hashes while still allowing old plain-text passwords to log in once and be upgraded.

## Requirements

- PHP 7.4+ with MySQLi enabled
- MySQL or MariaDB
- Apache/Nginx/PHP built-in server for local development

## Setup

1. Copy the environment template:
   ```bash
   cp .env.example .env
   ```
2. Update `.env` with your local database credentials.
   Use `APP_ENV=development` locally if you want detailed database connection errors.
3. Create a database matching `DB_NAME`.
4. Import `database_schema.sql` as a starting schema, then adjust column types/indexes if you already have production data.
5. Serve the repository from your PHP web server document root.
6. Open `index.php` in the browser.

## Validation

Run PHP syntax validation across the repository:

```bash
find . -maxdepth 1 -name '*.php' -print0 | xargs -0 -n1 php -l
```

## Security notes

- Do not commit `.env` or real credentials.
- Never use `APP_ENV=development` in production because it shows detailed database connection errors.
- Passwords are hashed for new and updated users; reset any old plain-text accounts before production use.
- More endpoints still need a future pass for CSRF tokens, authorization checks, and full prepared-statement coverage.
