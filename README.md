# LARAVEL COMPOSER SECURITY COMMAND

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabsInsight][ico-sensiolab]][link-sensiolab]

This is a Laravel 5.1.x/5.2.x package that provides an artisan command for testing security vulnerabilties into your composer.lock files.


Table of Contents
=================

  * [LARAVEL COMPOSER SECURITY COMMAND](#laravel-composer-security-command)
  * [Table of Contents](#table-of-contents)
  * [PREREQUISITES](#prerequisites)
    * [INSTALL](#install)
    * [USAGE](#usage)
      * [EXAMPLE:](#example)
    * [SCHEDULE COMMAND](#schedule-command)
    * [SCREENSHOOTS](#screenshoots)
  * [Testing](#testing)
  * [Contributing](#contributing)
  * [Security](#security)
  * [Credits](#credits)
  * [About Padosoft](#about-padosoft)
  * [License](#license)

  
# PREREQUISITES

LARAVEL 5.1+
GUZZLE 6+

## INSTALL

This package can be installed through Composer.

``` bash
composer require padosoft/laravel-composer-security
``` 
You must install this service provider.

``` php
// config/app.php
'provider' => [
    ...
    Padosoft\LaravelComposerSecurity\ComposerSecurityCheckServiceProvider::class,
    ...
];
```
You don't need to register the command in app/Console/Kernel.php, because it provides by ComposerSecurtyCheckServiceProvider register() method.

You can publish the config file of this package with this command:
``` bash
php artisan vendor:publish --provider="Padosoft\LaravelComposerSecurity\ComposerSecurityCheckServiceProvider"
```
The following config file will be published in `config/composer-security-check.php`
``` php
return array(
    'mailSubjectSuccess' => env(
        'SECURITY_CHECK_SUBJECT_SUCCESS',
        '[composer-security-check]: Ok - no vulnerabilities detected.'
    ),
    'mailSubjetcAlarm' => env(
        'SECURITY_CHECK_SUBJECT_ALARM',
        '[composer-security-check]: Alarm - vulnerabilities detected.'
    ),
    'mailFrom' => env('SECURITY_CHECK_MESSAGE_FROM', 'info@example.com'),
    'mailFromName' => env('SECURITY_CHECK_MESSAGE_FROM_NAME', 'Info Example'),
    'mailViewName' => env('SECURITY_CHECK_MAIL_VIEW_NAME', 'composer-security-check::mail'),
    'logFilePath' => env('SECURITY_CHECK_LOG_FILE_PATH', storage_path().'/composersecurityCheck.log')
 );
```

## USAGE

When the installation is done you can easily run command to print help:
```bash
php artisan composer-security:check
```

The `composer-security:check` command looks for every composer.lock file in the given path
and foreach composer.lock check for security issues in the project dependencies:
`php composer-security:check`

If you omit path argument, command look into current folder.

You can also pass the path as an argument:
`php composer-security:check /path/to/my/repos`

You can use * in path argument as jolly character i.e. `/var/www/*/*/`

By default, the command displays the result in console, but you can also
send an html email by using the `--mail`option:
```bash
php composer-security:check /path/to/my/repos --mail=mymail@mydomain.me
```
### EXAMPLE:

Here is a basic example to check composer.lock into these dir:
```bash
php artisan composer-security:check "/dit/to/check/*/*/"
```
Here is an example to send output report to mail:
```bash
php artisan composer-security:check "/dit/to/check/*/*/" --mail=mymail@mydomain
```
Here is an example to ignore two composer.lock vulnerabilities into two dir (if command found any vulnerabilities into these dir, write it into output but the email subject isn't set to ALERT):
```bash
php artisan composer-security:check "/dit/to/check/*/*/" --mail=mymail@mydomain --whitelist="/dir/to/put/in/witelist,/another/dir/to/put/in/witelist"
```


## SCHEDULE COMMAND

You can schedule a daily (or weekly etc..) report easly, by adding this line into `schedule` method in `app/Console/Kernel.php` :
```php
// app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    ...
	$schedule->command('composer-security:check "/dir/to/check/" --mail=mymail@mydomain')
            ->daily()
            ->withoutOverlapping()
            ->sendOutputTo(Config::get('composer-security-check.logFilePath'));
}
```

## SCREENSHOOTS

OUTPUT CONSOLE:
![screenshoot](https://raw.githubusercontent.com/padosoft/laravel-composer-security/master/resources/img/console-output.png)

EMAIL VIEW WITH ALERT:
![screenshoot](https://raw.githubusercontent.com/padosoft/laravel-composer-security/master/resources/img/alert-vulnerability.png)

EMAIL VIEW WITH VULNERABILITY WITELISTED:
![screenshoot](https://raw.githubusercontent.com/padosoft/laravel-composer-security/master/resources/img/warning-vulerability-witelisted.png)

# Testing
```bash
$ composer test
```

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
[ico-sensiolab]: https://insight.sensiolabs.com/projects/80fa0430-55ff-4079-a34e-d189a9d21d5e/small.png

[link-packagist]: https://packagist.org/packages/padosoft/laravel-composer-security
[link-travis]: https://travis-ci.org/padosoft/laravel-composer-security
[link-scrutinizer]: https://scrutinizer-ci.com/g/padosoft/laravel-composer-security/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/padosoft/laravel-composer-security
[link-downloads]: https://packagist.org/packages/padosoft/laravel-composer-security
[link-sensiolab]: https://insight.sensiolabs.com/projects/80fa0430-55ff-4079-a34e-d189a9d21d5e
[link-author]: https://github.com/lopadova
[link-contributors]: ../../contributors

