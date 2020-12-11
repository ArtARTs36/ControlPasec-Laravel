## ControlPasec

Система для организации документооборота.

## Зависимости

Для проекта написан ряд библиотек:

| #   | Название  | Описание   |
| ------------ | ------------ | ------------ |
| 1  | artarts36/cbr-course-finder  | Работа с курсами валют. Получение и обработка данных их внешнего источника (https://www.cbr-xml-daily.ru/)  |
|  2 | artarts36/laravel-holiday  | Работа с производственным календарем. Получение информации о выходных, рабочих, предпраздничных днях. Получение и обработка данных из внешнего источника (https://isdayoff.ru).  |
|  3 | artarts36/morpher  | Работа со склонениями в русском языке. Необходим для формирования корректного текста в документах. Содержит: клиент для работы с сайтом http://morpher.ru. Позволяет склонять существительные, прилагательные и даты   |
|  4 |  artarts36/pushall-sender  | Работа с PUSH уведомлениями. Работает с API сервиса http://pushall.ru  |
| 5  | artarts36/ru-spelling  | Работа с орфографией. Транслит,  преобразование чисел в формат нетто; справочник дней и месяцев  |
| 6  | artarts36/shell-command  | Объектно-ориентированная обертка над shell_exec. Позволяет строить сложные команды для выполнения bash интерпритатором  |

## Установка

- composer install
- php artisan key:generate
- php artisan project-install

## Команды

| #   | Команда  | Описание   |
| ------------ | ------------ | ------------ |
| 1 | php artisan serve | Запуск проекта |
| 2 | composer test | Запуск тестов |
| 3 | composer lint | Запуск проверки на соответствие кода стандартам PSR |
| 4  | php artisan get-currency-course:now | Получить курсы валют за сегодня |
| 5  | php artisan get-currency-course:week | Получить курсы валют за неделю |
| 6 | php artisan get-external-news | Получить новости из внешних источников |

## Посмотреть документацию
- php artisan serve --port=8000
- http://localhost:8000/api/documentation

## Вспомогательные команды
- php artisan l5-swagger:generate
- ./vendor/bin/phpstan analyse --memory-limit=2G

## Запуск очередей
- `php artisan queue:work redis --queue=document`
- `php artisan horizon`

## Обновить БД
- `php artisan db:wipe && php artisan migrate && php artisan db:seed`

## Установка и запуск под докером
- sh docker-project-install.sh
- Открыть http://localhost:8085

## Документация по проекту
* [Работа с проектом в docker-окружении](docs/run.docker.md)

## Полезная документация
* [Профилирование](docs/profiling.md)
* [Команды докера](docs/docker.commands.md)

## Инструменты
* [Удобный редактор readme](https://pandao.github.io/editor.md/en.html)
* [Удобный редактор swagger](https://editor.swagger.io)

## Заплатка для composer
- `COMPOSER_MEMORY_LIMIT=-1 {command}`
