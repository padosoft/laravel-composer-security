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
    public function testFindFiles($path,$fileName,$lockFile)
    {
        //File::shouldReceive('isDirectory')->andReturn(true);
        //File::shouldReceive('glob')->andReturn('/pippo/composer.lock');

        $this->assertEquals($this->fileHelper->findFiles($path,$fileName)[0],$lockFile);

    }

    /**
     * @return array
     */
    public function provider()
    {
        return array(
            array('', 'composer.lock', '/home/travis/build/padosoft/laravel-composer-security/laravel/composer.lock')
        );
    }
}
