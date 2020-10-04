<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/05/2017
 * Time: 21:52
 */

namespace Pandora\Config;


use Pandora\Contracts\Utils\iExtractFiles;
use Pandora\Utils\ExtractFiles;

/**
 * Class Files
 * @package Pandora\Config
 */
class Files
{
    /**
     * @var ExtractFiles
     */
    private $extractFiles;
    
    /**
     * Files constructor.
     *
     * @param iExtractFiles $extractFiles
     */
    public function __construct(iExtractFiles $extractFiles)
    {
        $this->extractFiles = $extractFiles;
    }
    
    /**
     * @param string $path
     *
     * @return array
     */
    public function load(string $path): array
    {
        $filesConfig = $this->extractFiles->files();
        
        $config = [];
        
        foreach ($filesConfig as $k => $file) {
            $config = array_merge($config, include $path . '/config/' . $file);
        }
        
        return $config;
    }
}