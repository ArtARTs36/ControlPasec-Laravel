## Установка проекта на локальной машине

* Необходимо клонировать/скачать данный репозиторий
* Создать базу данных (предпочтительнее PostgreSQL)
* Выполнить команду: `cp env.example .env`
* В появившемся файле .env указать параметры подключения к БД
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ControlPasec
DB_USERNAME=root
DB_PASSWORD=root
```
* Выполнить команду `composer install`
* Выполнить команду `php artisan migrate`
* Выполнить команду `php artisan project-install`
* Выполнить команду `php artisan compile-font-from-dompdf`
