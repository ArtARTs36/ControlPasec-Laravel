<p align="center">
    ControlPasec
</p>

## Установка

- composer install
- php artisan key:generate
- php artisan project-install

## Запуск
- php artisan serve

## Получить курсы валют
- За сегодня: `php artisan get-currency-course:now`
- За неделю: `php artisan get-currency-course:week`

## Получить новости из внешних источников
- `php artisan get-external-news`

## Запуск стабильных тестов
- vendor/phpunit/phpunit/phpunit --group=BaseTest

## Посмотреть документацию
- php artisan serve --port=8000
- http://localhost:8000/api/documentation

## Вспомогательные команды
- php artisan l5-swagger:generate
- ./vendor/bin/phpstan analyse --memory-limit=2G

## Профайлер
- установка:
- `npm install laravel-profiler-client --save-dev`
- запуск:
- `php artisan profiler:server`
- `php artisan profiler:client`

## Запуск очередей
- `php artisan queue:work database --queue=document`

## Обновить БД
- `php artisan db:wipe && php artisan migrate && php artisan db:seed`
