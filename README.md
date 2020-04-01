<p align="center">
    ControlPasec
</p>

## Установка

- composer install
- php artisan key:generate
- php artisan project-install

## Запуск
- php artisan serve

## Запуск стабильных тестов
- vendor/phpunit/phpunit/phpunit --group=BaseTest

## Посмотреть документацию
- php artisan serve --port=8000
- http://localhost:8000/api/documentation

## Вспомогательные команды
- php artisan l5-swagger:generate
- ./vendor/bin/phpstan analyse --memory-limit=2G
