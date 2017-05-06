<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/04/2017
 * Time: 07:26
 */

namespace Pandora\Builder;

class BuilderApiIndex
{
    use BuilderTrait;
    
    /**
     * @return string
     */
    public function write(): string
    {
        $this->writeHead();
        $this->writeIncludes();
        $this->writeSlimConfig();
        $this->writeSlim();
        
        return $this->write;
    }
    
    /**
     * @return string
     */
    private function writeIncludes(): string
    {
        $text = $this->line("require '../bootstrap.php';", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeSlimConfig(): string
    {
        $text  = $this->line("\$config['displayErrorDetails']    = true;", 0, 1);
        $text .= $this->line("\$config['addContentLengthHeader'] = false;", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeSlim(): string
    {
        $text = $this->line("\$app = new Slim\\App(['settings' => \$config]);", 0, 2);
        $text .= $this->line("// Instância da conexão com banco de dados para ser manipulada pelo Slim", 0, 1);
        $text .= $this->line("\$container['conn'] = \$conn;", 0, 2);
        $text .= $this->line("include 'routes.php';", 0, 2);
        $text .= $this->line("\$app->run();", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
}