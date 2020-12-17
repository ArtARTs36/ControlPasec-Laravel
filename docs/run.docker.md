## Работа с проектом в docker-окружении

### Установка

* Выполнить команду `sh docker-project-install.sh`
* Открыть http://localhost:8888

### Обслуживание

| #   | Команда  | Описание   |
| ------------ | ------------ | ------------ |
| 1 | sh docker-check-versions-packages.sh | Проверка версий установленных пакетов |
| 2 | sh docker-yarn-build.sh | Сборка фронт-енда |
| 3 | sh docker-composer-install.sh | Сборка зависимостей бэк-енда |
