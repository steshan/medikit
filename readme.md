# Medikit

Software for managing medicine stock at home.

## Requirements

 - Apache
 - PHP >=7.1.3
   - Ctype PHP Extension
   - JSON PHP Extension
   - Mbstring PHP Extension
   - OpenSSL PHP Extension
   - PDO PHP Extension
   - Tokenizer PHP Extension
   - XML PHP Extension
   - LDAP PHP Extension
 - MySQL
 

## Installation

Install [composer](https://getcomposer.org/). Download application [sources](https://github.com/steshan/medikit) and unpack (ex. `/var/www/medikit/`).

Ensure that webserver document root points to public/ (ex. `/var/www/medikit/public/`). Make `storage` and `bootstrap/cache` directories are writable by webserver.

Run `composer install` to install application dependencies
```
cd /var/www/medikit/
composer install
```

Create empty database with `utf8mb4` charset and `utf8mb4_unicode_ci` collation
```
CREATE DATABASE `medikit` DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Create database user with limited privileges
```
CREATE USER `medikit`@`%` IDENTIFIED BY 'medikitpassword`;
GRANT SELECT,INSERT,UPDATE,DELETE on `medikit`.* to `medikit`@`%`; 
```

Copy or rename `.env.example` file to `.env`. Edit `.env` to setup correct database credentials and run `php artisan migrate` to create tables.
