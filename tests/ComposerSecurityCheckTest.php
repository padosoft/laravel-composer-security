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
    protected $composerSecurityCheck;

    public function setUp()
    {
        $this->guzzle = new Client();
        $this->composerSecurityCheck = new ComposerSecurityCheck($this->guzzle);
        parent::setUp();
    }

    /** @test */
    public function testHardWorkKO()
    {
        Artisan::call('composer-security:check',['path'=>__DIR__.'\test_file\composer_ko','--mail'=>'helpdesk@padosoft.com']);
        $output = Artisan::output();
        $this->assertContains('Trovate',$output);
    }

    /** @test */
    public function testHardWorkOK()
    {
        Artisan::call('composer-security:check',['path'=>__DIR__.'\test_file\composer_ok','--mail'=>'helpdesk@padosoft.com','--whitelist'=>'Y:\laravel-packages\www\laravel\5.2.x\packages\padosoft\laravel-composer-security\tests\,paperino']);
        $output = Artisan::output();
        $this->assertContains('no vulnerabilities detected',$output);
        //$this->assertEquals(File::get(__DIR__.'/artisan_output'),$output);
    }

    /** @test */
    public function testHardWorkWhitelist()
    {
        Artisan::call('composer-security:check',['path'=>__DIR__.'\test_file\composer_ko','--mail'=>'helpdesk@padosoft.com','--whitelist'=>__DIR__.'\test_file\composer_ko']);
        $output = Artisan::output();
        $this->assertContains('no vulnerabilities detected',$output);
        //$this->assertEquals(File::get(__DIR__.'/artisan_output'),$output);
    }

    /** @test */
    public function testHardWorkMultiplePath()
    {
        Artisan::call('composer-security:check',['path'=>__DIR__.'\test_file\composer_ko,'.__DIR__.'\test_file\composer_ok' ,'--mail'=>'helpdesk@padosoft.com','--whitelist'=>__DIR__.'\test_file\composer_ko']);
        $output = Artisan::output();
        $this->assertContains('no vulnerabilities detected',$output);
        //$this->assertEquals(File::get(__DIR__.'/artisan_output'),$output);
    }

    /** @test */
    public function testFindFilesComposerLock()
    {
        $path = "./resources";
        $arrFiles = $this->invokeMethod($this->composerSecurityCheck, 'findFilesComposerLock', [$path]);

        $this->assertTrue(is_array($arrFiles));
        $this->assertTrue(count($arrFiles)<1);
    }

}
