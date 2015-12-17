# PROGETTO TESSERA SANITARIA

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![HHVM Status][ico-hhvm-status]][link-hhvm-status]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabsInsight][ico-sensiolab]][link-sensiolab]

Il package permette la creazione di file XML delle prestazioni mediche per il servizio nazionale sanità secondo il formato XML della tessera sanitaria definito nel DM 31/07/2015.
Per maggiori info si veda il Portale della Tessera Sanitaria: http://sistemats1.sanita.finanze.it/wps/portal/

Table of Contents
=================

  * [PROGETTO TESSERA SANITARIA](#progetto-tessera-sanitaria)
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

    TMP_PATH = "c:/xampp/htdocs/tessera-sanitaria/tests/tmp/";
    CERT_FILE = "c:/xampp/htdocs/tessera-sanitaria/tests/certificates/test.crt";
    OPENSSL_EXE_PATH = "c:/OpenSSL-Win32/bin/";

Esempio Linux:

    TMP_PATH = "/var/www/html/tessera-sanitaria/tests/tmp/";
    CERT_FILE = "/var/www/html/tessera-sanitaria/tests/certificates/test.crt";
    OPENSSL_EXE_PATH = "";

### Permission folder
Rendere queste directory scrivibili da php:
``` bash
chmod -R 777 /var/www/html/padosoft/tessera-sanitaria/tests/tmp/
chmod -R 777 /var/www/html/padosoft/tessera-sanitaria/tests/output/
chmod -R 777 /var/www/html/padosoft/tessera-sanitaria/tests/log/
chmod -R 777 /var/www/html/padosoft/tessera-sanitaria/vendor/luminous/luminous/cache/
```

# CHANGE LOG

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

# USO DELLA LIBRERIA

## ESEMPIO BASE

L'utilizzo base del pacchetto, al netto del caricamento delle dipendenze, prevede l'istanza della classe per il tracciato, il passaggio dei dati necessari alla creazione dell'XML e il successivo recupero del codice in una variabile di tipo stringa:
``` php
// Istanzia la classe per il tracciato
$objTracciato = new Tracciato($objValidateHelper);

// Crea XML
$rispostaTracciato = $objTracciato->doTracciato($codiceRegione, $codiceAsl, $codiceSSA, $cfProprietario, $pIva, $arrSpesa, $arrVociSpesa);
    
// Recupera l'XML creato
$strXML = $objTracciato->getXml();
```
Successivamente, la stringa ricavata potrà essere usata per:

- Stampare direttamente il codice a video
- Creazione file XML
- Creazione file XML compresso

tramite vari metodi analizzati nel successivo paragrafo "Output".

## OUTPUT

La stringa XML recuperata dal metodo getXml() della classe Tracciato può essere utilizzata nei seguenti modi:

### Output a video

I metodi della classe PrintHelper stampano a video il codice XML generato.
Servendosi della libreria Luminous (https://github.com/markwatkinson/luminous) , il codice viene formattato tramite un'interfaccia chiara ed esteticamente gradevole.
``` php
// Stampa header template html
PrintHelper::printHtmlHeader();
    
// Recupera l'esito e gli eventuali errori
PrintHelper::printError($objTracciato, $logger, $objValidateHelper);
    
// Stampa l'XML formattato
PrintHelper::printXML($strXML);
    
// Stampa comandi
PrintHelper::printButton();
    
// Stampa html footer
PrintHelper::printHtmlFooter();
```
### Creazione File

La classe IOHelper permette di trasformare la stringa XML nel corrispondente file, sia in versione estesa che compressa. I due metodi che si occupano di queste operazioni sono i seguenti: 
``` php
// Salva XML su file
IOHelper::outputFile($strXML, $pathOutput, $basePath);

// Crea lo zip al volo e salva su $destinationZip
IOHelper::zipFileOntheFly($pathOutput, $destinationZip, $strXML);
```
## VALIDAZIONE

La validazione dei dati passati al metodo doTracciato avviene in modo trasparente per l'utente, tramite la classe ValidateHelper richiamata dal metodo stesso. I parametri di validazione si basano sul documento ufficiale fornito dal ministero della sanità:
http://sistemats1.sanita.finanze.it/wps/wcm/connect/487b0bba-6a65-42f9-8b43-2fb907fe7e91/730+Schema+dati+spesa+sanitaria+(28_09_2015)_v2.pdf?MOD=AJPERES&CACHEID=487b0bba-6a65-42f9-8b43-2fb907fe7e91

# ESEMPIO COMPLETO

Un esempio esaustivo di tutte le funzionalità summenzionate si trova in /tests/index.php , che carica anche tutte le dipendenze necessarie.
Tutti i precedenti esempi di codice sono stati ricavati da questo file. 

## Screenshot esempio

Uno screenshot di esempio si trova nella cartella resources/img
![demo tessera-sanitaria](https://raw.githubusercontent.com/padosoft/tessera-sanitaria/master/resources/img/tessera_sanitaria_tests.png)

# Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

# Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

# Credits

- [Lorenzo Padovani](https://github.com/lopadova)
- Raffaele Masi
- [All contributors](https://github.com/thephpleague/skeleton/contributors)

# About Padosoft
Padosoft is a software house based in Florence, Italy. Specialized in E-commerce and web sites.

# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/padosoft/tessera-sanitaria.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/padosoft/tessera-sanitaria/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/padosoft/tessera-sanitaria.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/padosoft/tessera-sanitaria.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/padosoft/tessera-sanitaria.svg?style=flat-square
[ico-sensiolab]: https://insight.sensiolabs.com/projects/a79cb441-a1e0-43f7-a343-d1598847ccfc/small.png
[ico-hhvm-status]: http://hhvm.h4cc.de/badge/padosoft/tessera-sanitaria.svg?style=flat

[link-packagist]: https://packagist.org/packages/padosoft/tessera-sanitaria
[link-travis]: https://travis-ci.org/padosoft/tessera-sanitaria
[link-scrutinizer]: https://scrutinizer-ci.com/g/padosoft/tessera-sanitaria/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/padosoft/tessera-sanitaria
[link-downloads]: https://packagist.org/packages/padosoft/tessera-sanitaria
[link-sensiolab]: https://insight.sensiolabs.com/projects/a79cb441-a1e0-43f7-a343-d1598847ccfc
[link-hhvm-status]: http://hhvm.h4cc.de/package/padosoft/tessera-sanitaria
[link-author]: https://github.com/lopadova
[link-contributors]: ../../contributors

