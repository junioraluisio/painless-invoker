<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 04/05/2017
 * Time: 07:07
 */

namespace Invoker\Auth;


class Token
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function load(string $text)
    {
        $salt = '?#ATEw_u6p@draHEyakeD32$eStAG7=$';
        
        $text = preg_replace('/[^0-9]/', '', $text);
        
        $txt = md5($text) . '.' . md5($salt);
        
        return sha1($txt);
        
    }
}