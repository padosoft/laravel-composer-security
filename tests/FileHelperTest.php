<?php
/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 07/12/2015
 * Time: 16:39
 */

namespace Padosoft\LaravelComposerSecurity\Test;

use \Illuminate\Support\Facades\File;
use Padosoft\LaravelComposerSecurity\FileHelper;

class FileHelperTest extends TestBase
{
    protected $fileHelper;

    public function setUp()
    {
        $this->fileHelper = new FileHelper();
        parent::setUp();
    }

    /**
     * @test
     * @param $path
     * @param $fileName
     * @param $lockFile
     * @dataProvider provider
     */
    public function testFindFiles($path,$fileName)
    {
        $this->assertTrue(is_array($this->fileHelper->findFiles($path,$fileName)));
        $this->assertTrue(count($this->fileHelper->findFiles($path,$fileName))>0);
    }

    /**
     * @test
     */
    public function testAdjustPath()
    {
        $arr = $this->fileHelper->adjustPath('');
        $this->assertTrue(is_array($arr) && count($arr)==0);

        $arr = $this->fileHelper->adjustPath('uno/due/tre/');
        $this->assertTrue(is_array($arr) && count($arr)==1 && $arr[0]=='uno/due/tre/');

        $arr = $this->fileHelper->adjustPath('uno/due/tre');
        $this->assertTrue(is_array($arr) && count($arr)==1);
        $this->assertTrue($arr[0]=='uno/due/tre/');

        $arr = $this->fileHelper->adjustPath('uno/due/tre,quattro/cinque/sei/');
        $this->assertTrue(is_array($arr) && count($arr)==2);
        $this->assertTrue($arr[0]=='uno/due/tre/');
        $this->assertTrue($arr[1]=='quattro/cinque/sei/');
    }

    /**
     * @return array
     */
    public function provider()
    {
        return array(
            array('', 'composer.lock')
        );
    }
}
