## Работа с проектом в docker-окружении

### Установка

* Выполнить команду `sh docker-project-install.sh`
* Открыть http://localhost:8888

### Обслуживание

| #   | Команда  | Описание   |
| ------------ | ------------ | ------------ |
| 1 | sh scripts/docker/check-versions.sh | Проверка версий установленных пакетов |
| 2 | sh scripts/docker/yarn-build.sh | Сборка фронт-енда |
| 3 | sh scripts/docker/frontend-update.sh | Обновление фронт-енда |
| 4 | sh scripts/docker/composer-install.sh | Сборка зависимостей бэк-енда |
| 5 | sh scripts/docker/backend-update.sh | Обновление бэк-енда |
| 6 | sh scripts/docker/supervisor-update.sh | Обновление конфигурации Supervisor и перезапуск |
| 7 | sh scripts/docker/supervisor-start.sh | Запуск Supervisor |
| 8 | sh scripts/docker/project-install.sh | Установка проекта |
