composer install
docker compose down && docker compose up -d
docker exec -it z_app php bin/console doctrine:database:create
docker exec -it z_app php bin/console doctrine:migrations:migrate -q
docker exec -it z_app php bin/console cache:clear
docker exec -it z_app php bin/console assets:install
docker exec -it z_app npm i
docker exec -it z_app npm run build
docker exec -it z_app find . -exec chmod 777 {} \;
