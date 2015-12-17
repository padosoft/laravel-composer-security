<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 07/12/2015
 * Time: 16:39
 */

namespace Padosoft\Composer\Test;

use \Illuminate\Support\Facades\File;
use Padosoft\Composer\FileHelper;
use Padosoft\Composer\MailHelper;
use \Mockery as m;
use Illuminate\Support\Facades\Config;


class MailHelperTest extends \MailTestCase
{

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

    /** @test
     * @param $vul
     * @dataProvider provider
     */
    public function testSendEmailSuccess()
    {
        //$mail = new MailHelper($this->mockCommand);
        $this->mailHelper->sendEmail(true ,"info@test.com",[]);
        $response = $this->getLastEmailJson();
        $this->assertEmailBodyContains(Config::get('composer-security-check.mailSubjectSuccess'),$response);

    }

    /** @test
     * @param $vul
     * @dataProvider provider
     */
    public function testSendEmailAlarm($vul)
    {
        //$mail = new MailHelper($this->mockCommand);
        $this->mailHelper->sendEmail(false ,"info@test.com",$vul);
        $response = $this->getLastEmailJson();
        $this->assertEmailBodyContains(Config::get('composer-security-check.mailSubjetcAlarm'),$response);
    }

    public function provider()
    {

        return array(
            array(
                array(
                    array('name'=>'vulnerabilità 1','version'=>'1.0','advisories'=>'testo vulnerabilità 1'),
                    array('name'=>'vulnerabilità 2','version'=>'2.0','advisories'=>'testo vulnerabilità 2')
                )
            )
        );
    }

}