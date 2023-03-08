<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

This project is an integration of some of [SWAPI](https://swapi.dev/) endpoints, more specifically:
- 👤 People
- 🌎 Planets
- 🚀 Vehicles

Authentication is done with JWT. A third-party package was used for this, you can check it out right [here](https://github.com/PHP-Open-Source-Saver/jwt-auth).

## System Requirements

* PHP: ^8.1
* Composer

Or

* Docker

### Setup

1. Clone repo
2. Copy .env.example

    ```
    cp .env.example .env
    ```

3. Install dependencies

    ```
    composer install
    ```

4. Run the following commands:

    ```
    If you use PHP:

    php artisan key:generate //Generate Laravel key
    php artisan jwt:secret //Generate JWT secret & algorithm
    php artisan migrate --seed //Run migrations and seeder

    If you use Docker:

    sail up -d
    sail artisan key:generate
    sail artisan jwt:secret
    sail artisan migrate --seed
    ```

## Running

I recommend running the project with Sail since you don't have to worry about having to install the necessary tools to run it, and take advantage of Docker.

When using Docker, run: 
```
sail up -d
```

When using PHP, run: 
```
php artisan serve
```

### Configuring A Bash Alias

By default, Sail commands are invoked using the `vendor/bin/sail` script that is included with all new Laravel applications:

However, instead of repeatedly typing `vendor/bin/sail` to execute Sail commands, you may wish to configure a Bash alias that allows you to execute Sail's commands more easily:

```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

### Starting & Stopping Sail

```
sail up
```

To start all the Docker containers in the background, you may start Sail in "detached" mode:

```
sail up -d
```

To stop all of the containers, you may simply press Control + C to stop the container's execution. Or, if the containers are running in the background, you may use the stop command:

```
sail stop
```

For more info refer to <https://laravel.com/docs/9.x/sail>

### Testing user

You can use the following credentials to log in as the default user, or you can create a user of your own using the `register` API:
- Email: gianfrancorocco@example.com
- Password: password
