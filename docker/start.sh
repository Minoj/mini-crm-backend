#!/bin/bash
cd /var/www/html

touch .env

mkdir -p var/cache var/log
chmod -R 777 var/

if [ ! -f config/jwt/private.pem ]; then
    mkdir -p config/jwt
    php bin/console lexik:jwt:generate-keypair --no-interaction
fi

php bin/console doctrine:migrations:migrate --no-interaction

php-fpm -D
nginx -g "daemon off;"
