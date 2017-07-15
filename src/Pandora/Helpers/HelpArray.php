<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/07/2017
 * Time: 17:04
 */
if (!function_exists('lastItemArray')) {
    function lastItemArray(array $array, string $item)
    {
        $keys = array_keys($array);
        $end  = end($keys);
        
        return ($end == $item) ? true : false;
    }
}