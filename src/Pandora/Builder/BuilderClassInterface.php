<?php
/**
 * Created by PhpStorm.
 * D: Junior
 * Date: 11/03/2017
 * Time: 10:26
 */

namespace Pandora\Builder;

/**
 * Class BuilderClassInterface
 * @package Pandora\Builder
 */
class BuilderClassInterface
{
    use BuilderTrait;
    
    /**
     * Escreve a classe
     *
     * @return string
     */
    public function write(): string
    {
        $this->writeHead();
        $this->writeNamespace();
        $this->writeStartClass();
        $this->writeSettersGetters();
        $this->writeFoot();
        
        return $this->write;
    }
    
    /**
     * Escreve o comentário dos atributos e métodos setters
     *
     * @param $field
     *
     * @return string
     */
    private function writeComment($field): string
    {
        $length = $field['max_length'];
        
        $comment = $field['comment'] . '. [max-length: ' . $length . ']';
        
        return $comment;
    }
    
    /**
     * Escreve o início da classe
     *
     * @return string
     */
    private function writeStartClass(): string
    {
        $text = "";
        
        $text .= $this->line("interface i" . $this->getClassName(), 0, 1);
        $text .= $this->line("{", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o namespace da classe
     *
     * @return string
     */
    private function writeNamespace(): string
    {
        $text = "";
        
        $text .= $this->line("namespace " . $this->namespaceInterface . ';', 0, 3);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve os métodos getters e setters da classe
     *
     * @return string
     */
    private function writeSettersGetters(): string
    {
        $fields = $this->fields;
        
        $text = "";
        
        foreach ($fields as $field) {
            $name_flag = $field['name_flag'];
            
            $type = $this->varTypePHPDoc($field['type']);
            
            $comment = $this->writeComment($field);
            
            $methodSet = $field['method_set'];
            $methodGet = $field['method_get'];
            
            $text .= $this->line("/**", 4, 1);
            $text .= $this->line("* @param " . $type . " \$" . $name_flag . " " . $comment, 5, 1);
            $text .= $this->line("*/", 5, 1);
            $text .= $this->line("public function " . $methodSet . ';', 4, 2);
            
            $text .= $this->line("/**", 4, 1);
            $text .= $this->line("* return " . $type, 5, 1);
            $text .= $this->line("*/", 5, 1);
            $text .= $this->line("public function " . $methodGet . ';', 4, 2);
        }
        
        $this->write .= $text;
        
        return $text;
    }
}