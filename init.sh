composer install
docker compose down && docker compose up -d
docker exec -it z_app bash php bin/console doctrine:database:create
docker exec -it z_app bash php bin/console doctrine:migrations:migrate
docker exec -it z_app bash php bin/console cache:clear
docker exec -it z_app bash php bin/console assets:install
