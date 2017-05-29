<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/05/2017
 * Time: 07:18
 */

namespace Pandora\Utils;

use Pandora\Contracts\iExtractFiles;


class ExtractFiles implements iExtractFiles
{
    /**
     * @var
     */
    private $path;
    
    
    /**
     * ExtractFiles constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->setPath($path);
    }
    
    /**
     * @return array
     */
    public function files(): array
    {
        $dir = scandir($this->getPath());
        
        $items = array_diff($dir, ['..', '.']);
        
        $files = [];
        
        foreach ($items as $file) {
            $pathFile = $this->getPath() . DIRECTORY_SEPARATOR . $file;
            
            if(!is_dir($pathFile)){
                $files[] = $file;
            }
        }
        
        return array_values($files);
    }
    
    /**
     * @param $path
     *
     * @return $this
     */
    private function setPath($path)
    {
        $this->path = $path;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    private function getPath()
    {
        return $this->path;
    }
}