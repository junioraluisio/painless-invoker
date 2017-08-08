<?php
/**
 * Created by PhpStorm.
 * D: Junior
 * Date: 11/03/2017
 * Time: 10:26
 */

namespace Pandora\Builder;

class BuilderClass
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
        $this->writeAttributes();
        $this->writeSettersGetters();
        $this->writeFoot();
        
        return $this->write;
    }
    
    /**
     * Escreve os atributos da classe
     *
     * @return string
     */
    private function writeAttributes(): string
    {
        $fields = $this->fields;
        
        $text = "";
        
        foreach ($fields as $field) {
            $name_flag = $field['name_flag'];
            
            $type = $this->varTypePHPDoc($field['type']);
            
            $comment = $this->writeComment($field);
            
            $text .= $this->line("/**", 4, 1);
            $text .= $this->line("* @var " . $type . " \$" . $name_flag . " " . $comment, 5, 1);
            $text .= $this->line("*/", 5, 1);
            $text .= $this->line("private $" . $name_flag . ";", 4, 2);
        }
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$prefix = '" . $this->getPrefix() . "';", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$table  = '" . $this->getTable() . "';", 4, 2);
        
        $this->write .= $text;
        
        return $text;
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
     * Escreve o namespace da classe
     *
     * @return string
     */
    private function writeNamespace(): string
    {
        $text = "";
        
        $text .= $this->line("namespace App\\" . $this->getNamespace() . ';', 0, 3);
        
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
            $text .= $this->line("*", 5, 1);
            $text .= $this->line("* @return \$this", 5, 1);
            $text .= $this->line("*/", 5, 1);
            $text .= $this->line("public function " . $methodSet, 4, 1);
            $text .= $this->line("{", 4, 1);
            $text .= $this->line("\$this->" . $name_flag . " = \$" . $name_flag . ";", 8, 2);
            $text .= $this->line("return \$this;", 8, 1);
            $text .= $this->line("}", 4, 2);
            
            $text .= $this->line("/**", 4, 1);
            $text .= $this->line("* return " . $type, 5, 1);
            $text .= $this->line("*/", 5, 1);
            $text .= $this->line("public function " . $methodGet, 4, 1);
            $text .= $this->line("{", 4, 1);
            $text .= $this->line("return \$this->" . $name_flag . ";", 8, 1);
            $text .= $this->line("}", 4, 2);
        }
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function getPrefix(): string", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return \$this->prefix" . ";", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function getTable(): string", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return \$this->table" . ";", 8, 1);
        $text .= $this->line("}", 4, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o início da classe
     *
     * @return string
     */
    private function writeStartClass(): string
    {
        $text = "";
        
        $stringClass = "class " . $this->getClassName() . " implements iDataObject";
        
        $text .= $this->line("use Pandora\Contracts\Database\iDataObject;", 0, 3);
        
        $text .= $this->line($stringClass, 0, 1);
        $text .= $this->line("{", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
}