<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

ini_set('memory_limit', -1);

$iterator = Finder::create()
    ->files()
    ->exclude('Vendor')
    ->exclude('tests')
    ->in($dir = __DIR__.'/src')
;

$versions = GitVersionCollection::create($dir)
    ->addFromTags('*')
    ->add('master','master')
;

return new Sami($iterator,array(
    'theme'                => 'default',
    'title'                => 'Laravel Composer Security API',
    'versions'             => $versions,
    'build_dir'            => 'Y:/Public/laravel-packages/www/doc/padosoft/laravel-composer-security/build/%version%',
    'cache_dir'            => 'Y:/Public/laravel-packages/www/doc/padosoft/laravel-composer-security/cache/%version%',
    'default_opened_level' => 1,
));

