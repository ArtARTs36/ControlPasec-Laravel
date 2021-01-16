## Работа с проектом в docker-окружении

### Установка

* Выполнить команду `sh docker-project-install.sh`
* Открыть http://localhost:8888

### Обслуживание

| #   | Команда  | Описание   |
| ------------ | ------------ | ------------ |
| 1 | sh scripts/docker/check-versions.sh | Проверка версий установленных пакетов |
| 2 | sh scripts/docker/yarn-build.sh | Сборка фронт-енда |
| 3 | sh scripts/docker/composer-install.sh | Сборка зависимостей бэк-енда |
