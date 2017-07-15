<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 28/03/2017
 * Time: 06:31
 */

namespace Pandora\Builder;

class BuilderActionDisable
{
    use BuilderTrait;
    
    /**
     * Escreve o arquivo
     *
     * @return string
     */
    public function write(): string
    {
        $this->writeHead();
        $this->writeUses();
        $this->writeRequests();
        $this->writeObjects();
        $this->writeMessage();
        $this->writeReturn();
        
        return $this->write;
    }
    
    /**
     * @return string
     */
    private function writeMessage(): string
    {
        $text = "";
        
        $text .= $this->line("\$msg  = \$op['message'];", 0, 1);
        $text .= $this->line("\$msg .= !empty(\$op['error_info']) ? ' :: ' . \$op['error_info'] : '';", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeObjects(): string
    {
        $text = "";
        
        $nameParameter = $this->getNameParameter();
        $className     = $this->getClassName();
        
        $text .= $this->line("\$" . $nameParameter . " = new " . $className . "();", 0, 2);
        $text .= $this->line("\$" . $nameParameter . "->setId(\$id);", 0, 2);
        $text .= $this->line("\$" . $nameParameter . "Manager = new DataManager(\$conn, \$" . $nameParameter . ");", 0, 2);
        $text .= $this->line("\$op = \$" . $nameParameter . "Manager->disableById();", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeRequests(): string
    {
        $text = "";
        
        $text .= $this->line("\$id = isset(\$_REQUEST['ipt_id']) ? \$_REQUEST['ipt_id'] : '';", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeReturn(): string
    {
        $text = "";
        
        $text .= $this->line("\$ret = json_encode(\$msg);", 0, 2);
        $text .= $this->line("echo \$ret;", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeUses(): string
    {
        $text = "";
        
        $nms = $this->getNamespace() . '\\' . $this->getClassName();
        
        $text .= $this->line("use Pandora\\Database\\DataManager;", 0, 1);
        $text .= $this->line("use " . $nms . ";", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
}