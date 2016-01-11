<?php

namespace Padosoft\LaravelComposerSecurity;

use Illuminate\Support\Facades\File;

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
