<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 22/06/2018
 * Time: 07:18
 */

namespace Pandora\Email;

use Pandora\Contracts\Email\iTemplates;

class Templates implements iTemplates
{
    /**
     * @var string
     */
    private $path;
    
    /**
     * Templates constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    /**
     * @param string $template
     *
     * @return bool|string
     */
    public function load(string $template)
    {
        $filePath = $this->path . '/' . $template;
        
        try {
            $file = fopen($filePath, 'r');
            
            $text = fread($file, filesize($filePath));
            
            fclose($file);
            
            return $text;
        } catch (\Exception $e) {
            return 'Erro: ' . $e;
        }
    }
    
    /**
     * @param array  $itens
     * @param string $text
     *
     * @return mixed
     */
    public function replace(array $itens, string $text)
    {
        $search  = array_keys($itens);
        $replace = array_values($itens);
        
        return str_replace($search, $replace, $text);
    }
}