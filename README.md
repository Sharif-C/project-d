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
