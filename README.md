# IMPORTANT COMMANDS

## Start and rebuild server (ONLY FOR FIRST TIME INIT)
```shell
docker compose up -d --build server
```

## Start server
```shell
docker compose up -d server
```

## Restart server
```shell
docker compose restart
```

## Stop server
```shell
docker compose down
```


## Cache router
```shell
docker compose exec php php artisan route:cache
```

## Cache views
```shell
docker compose exec php php artisan view:cache
```

## Clear views
```shell
docker compose exec php php artisan view:clear
```

## Migration refresh
```shell
docker compose exec php php artisan migrate:fresh
```

## install node packages
```shell
docker compose run --rm node npm install
```

## install composer packages
```shell 
docker compose run --rm composer install
```