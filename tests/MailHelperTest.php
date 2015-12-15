<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 09/12/2015
 * Time: 10:30
 */

namespace Padosoft\Composer\Test;

use Illuminate\Support\Facades\Config;

class MailHelperTest extends TestBase
{
    public function setUp()
    {
        $this->mailHelper = new MailHelper();
        parent::setUp();
    }

    /** @test */
    public function testSendEmail()
    {

    }

}
