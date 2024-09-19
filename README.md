# Joint purchases service (Havka)

## Install 
```bash
php -r "file_exists('.env') || copy('.env.example', '.env');"
composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
php artisan key:generate
chmod -R 777 storage bootstrap/cache
```

## Start
```bash
php artisan serve
```

## Coding Style

Follows the [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard and the [PSR-4](https://www.php-fig.org/psr/psr-4/) autoloading standard.

## RUN PHPStan check
```bash
./vendor/bin/phpstan analyse
```

## RUN PHP-CS-fixer
```bash
./vendor/bin/php-cs-fixer fix app
```

## Quality Assurance

- **Coding Standards**: Using the [Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) tool fixes most issues in your code when you want to follow the PHP coding standards as defined in the PSR-1 and PSR-12 documents and many more.
- **Static Analysis**: Using the [PHPStan](https://github.com/phpstan/phpstan) PHP Static Analysis Tool focuses on finding errors in your code without actually running it.
  It catches whole classes of bugs even before you write tests for the code.
- **Testing**: [PestPhp](https://pestphp.com/docs/installation) is a Testing Framework with a focus on simplicity. It was carefully crafted to bring the joy of testing to PHP.
- **Vulnerabilities**: [Roave Security Advisories](https://github.com/Roave/SecurityAdvisories) ensures that your application doesn't have installed dependencies with known security vulnerabilities.
  This tool is backed by the [PHP Security Advisories Database](https://phpqa.io/projects/roave-security-advisories.html).

## Websites

- The [PHP.net](https://www.php.net/manual/en/index.php) Manual.
- [PHP-FIG](https://www.php-fig.org/psr/) PHP Standards Recommendations.
- PHP [The Right Way](https://phptherightway.com/).
- PHP [The Wrong Way](https://phpthewrongway.com/).
- PHP [Clean Code](https://github.com/jupeter/clean-code-php).
- [Laravel 9](https://laravel.com/docs/9.x) The PHP Framework.
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices).
- [PHPStorm](https://www.jetbrains.com/help/phpstorm) help.
- [MySql](https://dev.mysql.com/doc/refman/8.0/en/) documentation.
