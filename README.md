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

## Команды докера
- docker-compose up -d
- docker exec -it <имя или id контейнера> <shell>
- docker exec -it <имя или id контейнера> bash
- docker exec -it d18a28c93660 bash
- docker ps
- docker stop $(docker ps -a -q)
- docker rm $(docker ps -a -q) --force
