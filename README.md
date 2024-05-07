# IMPORTANT COMMANDS

## Start and rebuild server (ONLY FOR FIRST TIME INIT)
`docker compose up -d --build server`

## Start server
`docker compose up -d server`

## Restart server
`docker compose restart`

## Stop server
`docker compose down`

## Cache router
`docker compose exec php php artisan route:cache`

## Cache views
`docker compose exec php php artisan view:cache`

## Clear views
`docker compose exec php php artisan view:clear`

## get vender map
`docker compose run --rm composer install`

## update 
`docker compose run --rm composer update`

## node packetes
`docker compose run --rm node npm install`
`docker compose run --rm node npm update`
