#!/bin/bash
sed -i "s/'providers' => \[/'providers' => \[ Padosoft\\\\LaravelComposerSecurity\\\\ComposerSecurityCheckServiceProvider::class,/g" ./config/app.php