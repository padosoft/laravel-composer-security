<?php

namespace Padosoft\LaravelComposerSecurity\Test;

use Padosoft\LaravelComposerSecurity\MailHelper;
use \Mockery as m;
use Illuminate\Support\Facades\Config;
use MailThief\Facades\MailThief;
use MailThief\Testing\InteractsWithMail;

/**
 * Class MailHelperMockTest
 * @package Padosoft\LaravelComposerSecurity\Test
 */
class MailHelperMockTest extends \Padosoft\LaravelTest\TestBase
{
    use InteractsWithMail;

    protected $mockCommand;
    protected $mailHelper;

    public function setUp()
    {
        $this->mockCommand = m::mock('Illuminate\Console\Command');
        $this->mockCommand->shouldReceive('option')->with('verbose')->andReturn(true);
        $this->mockCommand->shouldReceive('line');
        $this->mockCommand->shouldReceive('error');
        $this->mockCommand->shouldReceive('info');
        $this->mockCommand->shouldReceive('comment');
        $this->mailHelper = new MailHelper($this->mockCommand);
        parent::setUp();
    }

    /**
     * @dataProvider provider
     */
    public function testSendEmailSuccess()
    {
        $this->mailHelper->sendEmail(true ,"info@test.com",[]);
        $this->seeMessageWithSubject(Config::get('composer-security-check.mailSubjectSuccess'));
    }

    /**
     * @param $vul
     * @dataProvider provider
     */
    public function testSendEmailAlarm($vul)
    {
        $this->mailHelper->sendEmail(false ,"info@test.com",$vul);
        $this->seeMessageWithSubject(Config::get('composer-security-check.mailSubjetcAlarm'));
    }


    public function provider()
    {

        return array(
            array(
                array(
                    array('name'=>'vulnerabilità 1','version'=>'1.0','advisories'=>'testo vulnerabilità 1','isOk'=>'false'),
                    array('name'=>'vulnerabilità 2','version'=>'2.0','advisories'=>'testo vulnerabilità 2','isOk'=>'true')
                )
            )
        );
    }

}
