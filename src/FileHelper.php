<?php

/**
 * Created by PhpStorm.
 * User: Alessandro
 * Date: 02/12/2015
 * Time: 13:12
 */


namespace Padosoft\Composer;

use File;

class FileHelper
{
    /**
     * @param $path
     * @param $fileName
     * @return array
     */
    public function findFiles($path, $fileName)
    {
        if ($path=='') {
            $path = base_path();
        }

        if (File::isDirectory($path)) {
            $path=str_finish($path, '/');

        }
        $path .= $fileName;

        return File::glob($path);
    }
}