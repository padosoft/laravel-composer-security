<?php
/**
 * Created by PhpStorm.
 * User: Lore
 * Date: 11/01/2016
 * Time: 09:32
 */

namespace Padosoft\LaravelComposerSecurity;


class WhiteList
{
    /**
     * @param $white
     * @return array
     */
    public static function adjustWhiteList($white)
    {
        if ($white == '') {
            return array();
        }

        $w = explode(",", str_replace('\\', '/', $white));

        $whitelist = array_map(function ($item) {
            return str_finish($item, '/');
        },
            $w
        );

        return $whitelist;
    }
}
