<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/05/2017
 * Time: 07:18
 */

namespace Pandora\Utils;


class ExtractFilesDir
{
    private $path;
    
    
    /**
     * Config constructor.
     */
    public function __construct($path)
    {
        $this->setPath($path);
    }
    
    public function files()
    {
        $dir = scandir($this->getPath());
        
        return array_diff($dir, ['..', '.']);
    }
    
    private function setPath($path)
    {
        $this->path = $path;
        
        return $this;
    }
    
    private function getPath()
    {
        return $this->path;
    }
}