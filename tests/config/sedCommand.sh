#!/bin/bash
sed -i 's/"psr-4": {/"psr-4": { "Padosoft\\\\LaravelComposerSecurity\\\\Test\\\\": ".\/vendor\/padosoft\/laravelcomposersecurity\/tests\/",/g' ./composer.json