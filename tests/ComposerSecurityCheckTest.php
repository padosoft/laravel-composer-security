<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 11/12/2015
 * Time: 14:01
 */

namespace Padosoft\LaravelComposerSecurity\Test;

use GuzzleHttp\Client;
use Padosoft\LaravelComposerSecurity\ComposerSecurityCheck;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Padosoft\LaravelComposerSecurity\Test\TestBase;

class ComposerSecurityCheckTest extends TestBase
{
    protected $guzzle;
    /** @test */
    public function testHardWork()
    {
        Artisan::call('composer-security:check',['path'=>__DIR__,'--mail'=>'helpdesk@padosoft.com','--whitelist'=>'Y:\laravel-packages\www\laravel\5.1.x\packages\padosoft\composer\tests\,paperino']);
        $output = Artisan::output();
        $this->assertContains('Trovate',$output);
        //$this->assertEquals(File::get(__DIR__.'/artisan_output'),$output);
    }


}
