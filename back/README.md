<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Dependencies

PHP 7.4+<br />
MySQL 5.4+<br />

## Starting

Run:<br />
```
composer install
php artisan migrate:install
php artisan migrate
php artisan serve
```

Endereço de acesso: http://localhost:8000

## Rotas

```
GET http://localhost:8000/api/todo/list
GET http://localhost:8000/api/todo/{uuid}
POST http://localhost:8000/api/todo
PUT http://localhost:8000/api/todo/{uuid}
DELETE http://localhost:8000/api/todo/{uuid}
```

