composer install
php bin/console cache:clear
docker compose down && docker compose up -d
