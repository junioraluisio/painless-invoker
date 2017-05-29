<?php
/**
 * Created by PhpStorm.
 * D: Junior
 * Date: 11/03/2017
 * Time: 10:26
 */

namespace Pandora\Builder;

/**
 * Class BuilderClassManagerInterface
 * @package Pandora\Builder
 */
class BuilderClassManagerInterface
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
        $this->writeMethodAll();
        $this->writeMethodFindById();
        $this->writeMethodFindByFieldsValues();
        $this->writeMethodInsert();
        $this->writeMethodUpdate();
        $this->writeMethodDisableById();
        $this->writeMethodEnableById();
        $this->writeFoot();
        
        return $this->write;
    }
    
    /**
     * Escreve o início da classe
     *
     * @return string
     */
    private function writeStartClass(): string
    {
        $text = "";
        
        $text .= $this->line("interface i" . $this->getClassName() . "Manager", 0, 1);
        $text .= $this->line("{", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método disableById()
     *
     * @return string
     */
    private function writeMethodDisableById(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function disableById(): array;", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método enableById()
     *
     * @return string
     */
    private function writeMethodEnableById(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function enableById(): array;", 4, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método all()
     *
     * @return string
     */
    private function writeMethodAll(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param string \$fields", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function all(\$fields = '*'): array;", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método findById()
     *
     * @return string
     */
    private function writeMethodFindById(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param string \$id", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function findById(\$id): array;", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeMethodFindByFieldsValues(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param array \$fieldsValues", 6, 1);
        $text .= $this->line("* @param int   \$limit", 6, 1);
        $text .= $this->line("*", 6, 1);
        $text .= $this->line("* @return array", 6, 1);
        $text .= $this->line("*/", 6, 1);
        $text .= $this->line("public function findByFieldsValues(array \$fieldsValues, int \$limit): array;", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método insert()
     *
     * @return string
     */
    private function writeMethodInsert(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function insert(): array;", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método update()
     *
     * @return string
     */
    private function writeMethodUpdate(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function update(): array;", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o namespace
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
}