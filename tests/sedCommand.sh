#!/bin/bash
sed -i 's/"psr-4": {/"psr-4": { "Padosoft\\\\Composer\\\\Test\\\\": "vendor\/padosoft\/composer\/tests\/",/g' /var/www/html/laravel/composer.json