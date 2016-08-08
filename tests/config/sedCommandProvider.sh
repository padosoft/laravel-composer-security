#!/bin/bash
sed -i "s/'providers' => \[/'providers' => \[ Padosoft\\\\LaravelComposerSecurity\\\\ComposerSecurityCheckServiceProvider::class,/g" ./config/app.php
sed -i "s/'providers' => \[/'providers' => \[ MailThief\\\\MailThiefServiceProvider::class,/g" ./config/app.php
sed -i "s/'aliases' => \[/'aliases' => \[ 'MailThief' => MailThief\\\\Facades\\\\MailThief::class,/g" ./config/app.php
