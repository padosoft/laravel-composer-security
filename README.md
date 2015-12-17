# PROGETTO LARAVEL COMPOSER SECURITY

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![HHVM Status][ico-hhvm-status]][link-hhvm-status]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabsInsight][ico-sensiolab]][link-sensiolab]

Il package un comando Artisan Laravel che consente di testare la sicurezza dei packages installati con il composer.lock.


Table of Contents
=================

  * [PROGETTO LARAVEL COMPOSER SECURITY](#progetto-laravel-composer-security)
  * [Table of Contents](#table-of-contents)
  * [PREREQUISITI](#prerequisiti)
    * [INSTALLAZIONE  OPENSSL](#installazione--openssl)
      * [Windows](#windows)
      * [Linux](#linux)
    * [GENERAZIONE CERTIFICATO E CHIAVE PUBBLICA](#generazione-certificato-e-chiave-pubblica)
      * [Windows](#windows-1)
      * [Linux](#linux-1)
      * [Comandi da eseguire](#comandi-da-eseguire)
    * [CONFIGURAZIONE](#configurazione)
      * [Enviroment](#enviroment)
      * [Permission folder](#permission-folder)
  * [CHANGE LOG](#change-log)
  * [USO DELLA LIBRERIA](#uso-della-libreria)
    * [ESEMPIO BASE](#esempio-base)
    * [OUTPUT](#output)
      * [Output a video](#output-a-video)
      * [Creazione File](#creazione-file)
    * [VALIDAZIONE](#validazione)
  * [ESEMPIO COMPLETO](#esempio-completo)
    * [Screenshot esempio](#screenshot-esempio)
  * [Contributing](#contributing)
  * [Security](#security)
  * [Credits](#credits)
  * [About Padosoft](#about-padosoft)
  * [License](#license)
  
# PREREQUISITI

PHP 5.4+
OpenSSL

## INSTALLAZIONE  OPENSSL

### Windows
Scaricare l'eseguibile da https://slproweb.com/products/Win32OpenSSL.html , lanciarlo e seguire le istruzioni a video.

### Linux
OpenSSL é già installato di default in tutte le principali distribuzioni.
Eventualmente, controllare la versione tramite il comando: 

``` bash
openssl version
```
se non aggiornata, lanciare i comandi:
``` bash
apt-get update && apt-get upgrade

apt-get install openssl
```

## GENERAZIONE CERTIFICATO E CHIAVE PUBBLICA

Collocare i file del certificato e delle chiavi nella directory specificata nella classe PathHelper (default: /tests/certificates).

Se non in possesso dei file ufficiali del ministero, è possibile crearli a scopo di test della libreria seguendo le istruzioni seguenti:

###Windows
Lanciare il comando dal prompt DOS posizionandosi nella directory dove si trova openssl, di default C:\OpenSSL-Win32\bin

###Linux
Non é necessario spostarsi nel path, in quanto openSSL dovrebbe essere già essere disponibile all'avvio della shell.

### Comandi da eseguire
generazione chiave privata
``` bash
openssl genrsa -out test.key 1024
```
generazione chiave pubblica
``` bash
openssl rsa -in test.key -out test.pub -pubout
```
generazione certificato    
``` bash
openssl req -new -x509 -out test.crt -key test.key -days 30
```
Vedere anche http://www.programmazione.it/index.php?entity=eitem&idItem=36568

## CONFIGURAZIONE

### Enviroment
Rinominare il file **.env.example** in **.env**
aprirlo con un editor di testo e impostare le variabili:
Esempio Windows:

    TMP_PATH = "c:/xampp/htdocs/laravel-composer-security/tests/tmp/";
    CERT_FILE = "c:/xampp/htdocs/laravel-composer-security/tests/certificates/test.crt";
    OPENSSL_EXE_PATH = "c:/OpenSSL-Win32/bin/";

Esempio Linux:

    TMP_PATH = "/var/www/html/laravel-composer-security/tests/tmp/";
    CERT_FILE = "/var/www/html/laravel-composer-security/tests/certificates/test.crt";
    OPENSSL_EXE_PATH = "";

### Permission folder
Rendere queste directory scrivibili da php:
``` bash

```

# CHANGE LOG

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

# USO DELLA LIBRERIA

## ESEMPIO BASE



# Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

# Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

# Credits

- [Lorenzo Padovani](https://github.com/lopadova)
- [All contributors](https://github.com/thephpleague/skeleton/contributors)

# About Padosoft
Padosoft is a software house based in Florence, Italy. Specialized in E-commerce and web sites.

# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/padosoft/laravel-composer-security.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/padosoft/laravel-composer-security/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/padosoft/laravel-composer-security.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/padosoft/laravel-composer-security.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/padosoft/laravel-composer-security.svg?style=flat-square
[ico-sensiolab]: https://insight.sensiolabs.com/projects/a79cb441-a1e0-43f7-a343-d1598847ccfc/small.png
[ico-hhvm-status]: http://hhvm.h4cc.de/badge/padosoft/laravel-composer-security.svg?style=flat

[link-packagist]: https://packagist.org/packages/padosoft/laravel-composer-security
[link-travis]: https://travis-ci.org/padosoft/laravel-composer-security
[link-scrutinizer]: https://scrutinizer-ci.com/g/padosoft/laravel-composer-security/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/padosoft/laravel-composer-security
[link-downloads]: https://packagist.org/packages/padosoft/laravel-composer-security
[link-sensiolab]: https://insight.sensiolabs.com/projects/a79cb441-a1e0-43f7-a343-d1598847ccfc
[link-hhvm-status]: http://hhvm.h4cc.de/package/padosoft/laravel-composer-security
[link-author]: https://github.com/lopadova
[link-contributors]: ../../contributors

