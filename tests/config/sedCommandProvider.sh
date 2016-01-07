#!/bin/bash
sed -i "s/'providers' => \[/'providers' => \[ Padosoft\\\\Composer\\\\ComposerSecurityCheckServiceProvider::class,/g" ./config/app.php