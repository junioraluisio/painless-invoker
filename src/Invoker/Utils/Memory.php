<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/04/2017
 * Time: 15:24
 */

namespace Invoker\Utils;


class Memory
{
    private function expense(){
        return round(((memory_get_peak_usage(true) / 1024) / 1024) . 2); // em MB
    }
    
    function show(){
        $msg  = 'Memory used: ' . $this->expense() . ' Mb';
        
        return $msg;
    }
}