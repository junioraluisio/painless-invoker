<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 16/07/2017
 * Time: 07:26
 */
if (!function_exists('path_root')) {
    /**
     * @return string
     */
    function path_root()
    {
        return dirname(__DIR__, 3);
    }
}

if (!function_exists('path_web')) {
    /**
     * @return string
     */
    function path_web()
    {
        $documentRoot = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']);
        
        $root = str_replace($documentRoot, '', dirname(__DIR__, 3));
        
        $root = str_replace('\\', '/', $root);
        
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $root;
    }
}