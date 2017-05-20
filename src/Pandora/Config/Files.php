<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/05/2017
 * Time: 21:52
 */

namespace Pandora\Config;


use Pandora\Utils\ExtractFilesDir;

class Files
{
    private $extractFilesDir;
    
    /**
     * Config constructor.
     *
     * @param \Pandora\Utils\ExtractFilesDir $extractFilesDir
     */
    public function __construct(ExtractFilesDir $extractFilesDir)
    {
        $this->extractFilesDir = $extractFilesDir;
    }
    
    /**
     * @return array
     */
    public function load(): array 
    {
        $filesConfig = $this->extractFilesDir->files();
        
        $config = [];
        
        foreach ($filesConfig as $k => $file) {
            $config = array_merge($config, include 'config/' . $file);
        }
        
        return $config;
    }
}