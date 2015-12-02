<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 18/11/2015
 * Time: 18:49
 */

namespace Padosoft\Composer\Tests;


use Illuminate\Support\Facades\Mail;
use Padosoft\Composer\ComposerSecurityCheck;
use GuzzleHttp\Client;

class ComposerSecurityCheckTest extends \TestCase
{
    /** @test */
    public function test()
    {
        //echo getenv('APP_ENV');
        //echo getenv('MAIL_HOST');

        $guzzle = new Client();
        $check = new ComposerSecurityCheck($guzzle);

        $check->
        $this->assertEquals(1,1);
    }

}
