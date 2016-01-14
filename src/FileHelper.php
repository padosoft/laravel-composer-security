<?php

namespace Padosoft\LaravelComposerSecurity;

use Illuminate\Support\Facades\File;

class FileHelper
{
    /**
     * @param $path
     * @param $fileName
     * @return array
     *
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

    public static function adjustPath($path)
    {

        if ($path == '') {
            return array();
        }

        $p = explode(",", str_replace('\\', '/', $path));

        $pathList = array_map(function ($item) {
            return str_finish($item, '/');
        },
            $p
        );

        return $pathList;
    }
}
