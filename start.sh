#!/bin/sh

# INITIALIZE CONTEINERS 
docker-compose up -d --build && 

#INSTALL DEPENDENCIES
docker exec -i php8_feeder bash -c "cd /var/www/html && composer install" &&

# EXECUTE MIGRATIONS DATABASE
docker exec -i php8_feeder bash -c "cd /var/www/html && php artisan migrate" &&

# GENERATE DOC API
docker exec -i php8_feeder bash -c "cd /var/www/html && php artisan scribe:generate" &&

echo "Aplicação configurada."