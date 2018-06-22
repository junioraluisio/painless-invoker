<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 22/06/2018
 * Time: 07:18
 */

namespace Pandora\Email;


class Templates implements iTemplates
{
    /**
     * @var string
     */
    private $path;
    
    /**
     * Templates constructor.
     */
    public function __construct()
    {
        $this->path = $_ENV['PATH_ROOT'] . $_ENV['MAIL_TEMPLATE_PATH'];
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
}