# Rental System

## Local development setup (Windows + WampServer)

The team uses [WampServer](https://www.wampserver.com/) to provide PHP and
MySQL locally. Follow these steps after checking out the repository.

### 1. Install the prerequisites

Install WampServer with PHP 8.3 or newer and MySQL. Also install:

- [Composer](https://getcomposer.org/)
- Node.js 20.19 or newer (or 22.12 or newer) and npm

Start WampServer and wait for its tray icon to turn green, indicating its
services are running. In WampServer's PHP menu, select PHP 8.3 or newer.

Composer and Artisan use the command-line PHP executable, which may differ
from the PHP version selected for Apache. Add the selected WampServer PHP
folder (for example, `C:\wamp64\bin\php\php8.3.x`) to the Windows `Path`
environment variable, then open a new PowerShell window. Ensure the PHP
`pdo_mysql` extension is enabled in the active PHP configuration.

Verify the tools available in PowerShell:

```powershell
php -v
composer --version
node --version
npm --version
```

Check that `php -v` reports PHP 8.3 or newer.

### 2. Open the project folder

In PowerShell, change to the project folder that contains `artisan` and
`composer.json`. For example:

```powershell
cd C:\path\to\Rental-Syatem\rental-system
```

### 3. Create the local database

Open WampServer's phpMyAdmin from its tray menu (or visit
`http://localhost/phpmyadmin`) and create a database named `rental_system`.
Alternatively, run this SQL in phpMyAdmin:

```sql
CREATE DATABASE rental_system;
```

### 4. Configure the application

Create a local `.env` file using the checked-in example:

```powershell
Copy-Item .env.example .env
```

The example is configured for WampServer's common local MySQL settings:
`127.0.0.1:3306`, database `rental_system`, username `root`, and a blank
password. If your WampServer MySQL credentials or port differ, update
`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

Do not commit `.env` or put real credentials in `.env.example`.

### 5. Install dependencies and prepare the database

From the project folder, run:

```powershell
composer run setup
```

This installs PHP and JavaScript dependencies, generates the Laravel
application key, runs database migrations, and builds frontend assets. Keep
WampServer's MySQL service running during setup.

### 6. Start the development environment

```powershell
composer run dev
```

This starts the Laravel web server, queue listener, and Vite development
server. Open [http://localhost:8000](http://localhost:8000) in your browser.
Leave this terminal running while you work; press `Ctrl+C` to stop the
development processes.

### 7. Run the tests

```powershell
composer run test
```

The test configuration uses an in-memory SQLite database, so the tests do not
use or modify your local MySQL database.

## Common setup issues

- **`could not find driver`**: enable PHP's `pdo_mysql` extension, then rerun
  the setup command.
- **Database connection refused**: start MySQL and check the host, port,
  database name, and credentials in `.env`.
- **Vite or Node version errors**: check `node --version`; this project needs
  Node.js 20.19+ or 22.12+.
- **A dependency install fails**: confirm that PHP/Composer and Node/npm are
  installed and available in the terminal, then rerun `composer run setup`.