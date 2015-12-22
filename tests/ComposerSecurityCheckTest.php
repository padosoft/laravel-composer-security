<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 11/12/2015
 * Time: 14:01
 */

namespace Padosoft\Composer\Test;

use GuzzleHttp\Client;
use Padosoft\Composer\ComposerSecurityCheck;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ComposerSecurityCheckTest extends TestBase
{
    protected $guzzle;
    /** @test */
    public function testHardWork()
    {
        Artisan::call('composer-security:check',['path'=>__DIR__,'--mail'=>'helpdesk@padosoft.com']);
        $output = Artisan::output();
        //dd($output);
        //File::put(__DIR__.'/artisan_output',$output);

        $this->assertEquals(File::get(__DIR__.'/artisan_output'),$output);
    }


}
