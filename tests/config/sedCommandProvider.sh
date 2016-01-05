#!/bin/bash
sed -i 's/Illuminate\\View\\ViewServiceProvider::class,/Illuminate\\View\\ViewServiceProvider::class, Padosoft\\Composer\\ComposerSecurityCheckServiceProvider::class,/' ./config/app.php