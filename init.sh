composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
docker compose down && docker compose up -d
