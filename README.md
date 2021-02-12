# Todo List App

Simple Todo List built with Vue.js 2 and Laravel 8

## Requirements

- MySQL 5.4+
- PHP 7.4+ (Recommended 8+)
- Composer
- NPM

## Installation

### Frontend

```bash
cd front
npm install
npm run serve
```

### Backend

```bash
cd back
cp .env.example .env
```

Change the configurations of .env file to your own settings and after that:

```bash
composer install
php artisan key:generate
php artisan migrate:install
php artisan migrate
php artisan serve
```

# TODO

- i18n frontend and backend
- caching with redis
- DDD Refactoring on backend
- authentication with firebase
