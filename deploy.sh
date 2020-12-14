#!/bin/bash
#time=$(date +'%Y%m%d%H%M')
#sed -i "s/LOAD_DATE=.*/LOAD_DATE=${time}/g" .env
# git pull
composer install
composer dump-autoload
npm install

php artisan cache:clear
php artisan route:clear
php artisan config:clear

# php artisan migrate

php artisan config:cache
php artisan route:cache

echo "Deploy successfully!";
