<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/05/2017
 * Time: 14:03
 */

namespace Invoker\Utils;


class Terminal
{
    /**
     * @param String $msg
     * @param int    $eolF
     * @param int    $eolL
     *
     * @return string
     */
    public function write(String $msg, Int $eolF, Int $eolL)
    {
        $txt = '';
        
        for ($i = 1; $i <= $eolF; $i++) {
            $txt .= PHP_EOL;
        }
        $txt .= $msg;
        
        for ($i = 1; $i <= $eolL; $i++) {
            $txt .= PHP_EOL;
        }
        
        return $txt;
    }
}