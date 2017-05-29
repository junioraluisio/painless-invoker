<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/05/2017
 * Time: 21:52
 */

namespace Pandora\Config;


use Pandora\Contracts\iExtractFiles;

/**
 * Class Files
 * @package Pandora\Config
 */
class Files
{
    /**
     * @var \Pandora\Utils\ExtractFiles
     */
    private $extractFiles;
    
    /**
     * Files constructor.
     *
     * @param \Pandora\Contracts\iExtractFiles $extractFiles
     */
    public function __construct(iExtractFiles $extractFiles)
    {
        $this->extractFiles = $extractFiles;
    }
    
    /**
     * @return array
     */
    public function load(): array 
    {
        $filesConfig = $this->extractFiles->files();
        
        $config = [];
        
        foreach ($filesConfig as $k => $file) {
            $config = array_merge($config, include 'config/' . $file);
        }
        
        return $config;
    }
}