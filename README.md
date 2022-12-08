<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel - Token Transaction

Se debe colocar el token en el env.example

- Se debe poner el token en el [env.example](.env.example) al final del archivo .
- Ejecutar el comando php artisan migrate --seed para correr las migraciones y el seeder que toma la data del API.

El proyecto usa un [Helper](app/Helpers/ConectadosApi.php) para obtener la data

En la vista [welcome](resources/views/welcome.blade.php) se indica cómo acceder a la información del punto 8

Para acceder al punto 9 es con el endpoint [users/{search?}](routes/api.php) que está en api.php

Se usa el patrón repositorio en este test.