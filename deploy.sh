#!/bin/sh
COMMANDS="
    cd /var/www/ifriend-platform;

    git pull;
    composer install;
    composer dump-autoload;

    php artisan cache:clear;
    php artisan route:clear;
    php artisan config:clear;
    php artisan view:clear;

    php artisan migrate;

    php artisan config:cache;
    php artisan route:cache;
    php artisan view:cache;
"

ssh deployer@192.168.1.16 -i ~/.ssh/deployerkey $COMMANDS
