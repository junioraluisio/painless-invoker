<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/04/2017
 * Time: 16:46
 */

namespace Pandora\Utils;

class Messages
{
    /**
     * @param String $text
     * @param int    $eolStart
     * @param int    $eolEnd
     *
     * @throws \Exception
     */
    static function exception(String $text, int $eolStart, int $eolEnd)
    {
        $msg = '';
        
        for ($i = 1; $i <= $eolStart; $i++) {
            $msg .= PHP_EOL;
        }
        
        $msg .= $text;
        
        for ($i = 1; $i <= $eolEnd; $i++) {
            $msg .= PHP_EOL;
        }
        
        throw new \Exception($msg);
    }
    
    /**
     * @param String $text
     * @param int    $eolStart
     * @param int    $eolEnd
     *
     * @return bool
     */
    static function console(String $text, int $eolStart, int $eolEnd)
    {
        $msg = '';
        
        for ($i = 1; $i <= $eolStart; $i++) {
            $msg .= PHP_EOL;
        }
        
        $msg .= $text;
        
        for ($i = 1; $i <= $eolEnd; $i++) {
            $msg .= PHP_EOL;
        }
        
        echo $msg;
        
        return true;
    }
}