## Команды докера

- `docker-compose up -d`
- `docker exec -it <имя или id контейнера> <shell>`
- `docker exec -it <имя или id контейнера> bash`
- `docker exec -it d18a28c93660 bash`
- `docker ps`
- `docker stop $(docker ps -a -q)`
- `docker rm $(docker ps -a -q) --force`
