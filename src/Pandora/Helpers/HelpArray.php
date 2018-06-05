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

/**
 * http://php.net/manual/pt_BR/function.shuffle.php
 */
if (!function_exists('keyShuffle')) {
    function keyShuffle(&$array)
    {
        if (!is_array($array) || empty($array)) {
            return false;
        }
        
        $tmp = [];
        
        foreach ($array as $key => $value) {
            $tmp[] = ['k' => $key, 'v' => $value];
        }
        
        shuffle($tmp);
        
        $array = [];
        
        foreach ($tmp as $entry) {
            $array[$entry['k']] = $entry['v'];
        }
        
        return true;
    }
}