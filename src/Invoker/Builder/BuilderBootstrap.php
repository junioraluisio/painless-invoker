<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/04/2017
 * Time: 07:22
 */

namespace Invoker\Builder;

class BuilderBootstrap
{
    use BuilderTrait;
    
    /**
     * @return string
     */
    public function write(): string
    {
        $this->writeHead();
        $this->writeIncludes();
        $this->writePaths();
        $this->writeRequires();
        $this->writeConstants();
        
        return $this->write;
    }
    
    /**
     * @return string
     */
    private function writeIncludes(): string
    {
        $text = $this->line("require 'vendor/autoload.php';", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writePaths(): string
    {
        $text = $this->line("define('DS', DIRECTORY_SEPARATOR);", 0, 2);
        $text .= $this->line("\$root = str_replace('bootstrap.php','', __FILE__);", 0, 1);
        $text .= $this->line("\$pathCore     = __DIR__  . DS. 'core' . DS;", 0, 1);
        $text .= $this->line("\$pathLibs     = \$pathCore . 'Libs' . DS;", 0, 1);
        $text .= $this->line("\$pathDebug    = \$pathLibs . 'debug' . DS;", 0, 1);
        $text .= $this->line("\$pathEntities = \$pathCore . 'Entities' . DS;", 0, 1);
        $text .= $this->line("\$pathUtils    = \$pathCore . 'Utils' . DS;", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeRequires(): string
    {
        $text = $this->line("require \$pathUtils . 'functions.php';", 0, 1);
        $text .= $this->line("require \$pathUtils . 'conn.php';", 0, 1);
        $text .= $this->line("require \$pathDebug . 'debug.php';", 0, 2);
        $text .= $this->line("\$pathRelative = relativePath();", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeConstants(): string
    {
        $text = $this->line("define('PATH_CORE', \$pathCore);", 0, 1);
        $text .= $this->line("define('PATH_ENTITIES', \$pathEntities);", 0, 1);
        $text .= $this->line("define('PATH_UTILS', \$pathUtils);", 0, 1);
        $text .= $this->line("define('PATH_DEBUG', \$pathDebug);", 0, 1);
        $text .= $this->line("define('PATH_RELATIVE', \$pathRelative);", 0, 0);
        
        $this->write .= $text;
        
        return $text;
    }
}