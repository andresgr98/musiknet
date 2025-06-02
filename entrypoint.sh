#!/bin/bash

composer install

while true; do
    
    output=$(symfony console doctrine:migrations:migrate --no-interaction 2>&1)
    
    echo "$output"

    if [ ! -f config/jwt/private.pem ]; then
        php bin/console lexik:jwt:generate-keypair
    fi

    if [[ "$output" == *"The version \"latest\" couldn't be reached"* ]]; then
        echo "No registered migrations. Exiting."
        break
    fi
    
    if [[ "$output" == *"[OK]"* ]]; then
        echo "Migrations completed successfully."
        break
    fi

    echo "Migrations not completed. Retrying in 5 seconds..."
    sleep 5
done

chmod -R 777 var/cache var/log

php-fpm