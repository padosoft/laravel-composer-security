#!/bin/bash
sed -i 's/"psr-4": {/"psr-4": { "Padosoft\\\\LaravelComposerSecurity\\\\Test\\\\": ".\/vendor\/padosoft\/laravel-composer-security\/tests\/",/g' ./composer.json