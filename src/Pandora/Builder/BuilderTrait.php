<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 25/03/2017
 * Time: 07:16
 */

namespace Pandora\Builder;

use Pandora\Database\Database;

/**
 * Trait BuilderTrait
 * @package Pandora\Builder
 */
trait BuilderTrait
{
    /**
     * @var string com o nome da classe
     */
    private $className;
    
    /**
     * @var string instância da classe \Entities\Database\DatabaseInterface
     */
    private $database;
    
    /**
     * @var array com as informações dos campos da tabela
     */
    private $fields;
    
    /**
     * @var string com o nome dos parâmetro usado no método construct da classe
     */
    private $nameParameter;
    
    /**
     * @var string com o namespace da classe
     */
    private $namespace;
    
    /**
     * @var string com o namespace da interface
     */
    private $namespaceInterface;
    
    /**
     * @var string com o prefixo que compõe o nome dos campos
     */
    private $prefix;
    
    /**
     * @var string com o nome da tabela com prefixo
     */
    private $table;
    
    /**
     * @var string com o nome da tabela sem o prefixo
     */
    private $tableName;
    
    /**
     * @var string
     */
    private $write = "";
    
    /**
     * BuilderTrait constructor.
     *
     * @param \Pandora\Database\Database|null $database
     */
    function __construct($database = null)
    {
        if ($database instanceof Database) {
            $tbl = $database->getTable();
            $fld = $database->getFields();
            
            $this->setDatabase($database)
                 ->setTable($tbl)
                 ->setTableName($tbl)
                 ->setNameParameter($tbl)
                 ->setClassName($tbl)
                 ->setNamespace()
                 ->setNamespaceInterface()
                 ->setFields($fld)
                 ->setPrefix();
        }
    }
    
    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
    
    /**
     * @param string $table
     *
     * @return $this
     */
    public function setClassName(string $table)
    {
        $arrTableName = explode('_', $table);
        
        $count = count($arrTableName);
        
        $className = '';
        
        for ($i = 1; $i <= $count; $i++) {
            $subName = isset($arrTableName[$i]) ? $arrTableName[$i] : '';
            
            $className .= ucfirst($subName);
        }
        
        $this->className = $className;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }
    
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }
    
    /**
     * @param string $tableName
     *
     * @return $this
     */
    public function setTableName(string $tableName)
    {
        $arrTableName = explode('_', $tableName);
        
        $tableName = isset($arrTableName[0]) ? ucfirst($arrTableName[0]) : '::ERROR::';
        
        $this->tableName = $tableName;
        
        return $this;
    }
    
    /**
     * @param \Pandora\Database\Database $database
     *
     * @return $this
     */
    public function setDatabase(Database $database)
    {
        $this->database = $database;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }
    
    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getNameParameter(): string
    {
        return $this->nameParameter;
    }
    
    /**
     * @param string $table
     *
     * @return $this
     */
    public function setNameParameter(string $table)
    {
        $arrTableName = explode('_', $table);
        
        $count = count($arrTableName);
        
        $nameParameter = '';
        
        for ($i = 1; $i <= $count; $i++) {
            $subName = isset($arrTableName[$i]) ? $arrTableName[$i] : '';
            
            $nameParameter .= $subName;
        }
        
        $this->nameParameter = $nameParameter;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
    
    /**
     * @return string
     */
    public function getNamespaceInterface(): string
    {
        return $this->namespaceInterface;
    }
    
    /**
     * @return $this
     */
    public function setNamespace()
    {
        $this->namespace = 'Entities\\' . $this->getTableName() . '\\' . $this->getClassName();
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function setNamespaceInterface()
    {
        $this->namespaceInterface = 'Entities\\Contracts\\' . $this->getTableName() . '\\' . $this->getClassName();
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
    
    /**
     * @return string
     */
    public function setPrefix(): string
    {
        $keys = array_keys($this->fields);
        
        $arrNameVar = explode('_', $keys[0]);
        
        $prefix = array_shift($arrNameVar) . '_';
        
        $this->prefix = $prefix;
        
        return $prefix;
    }
    
    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
    
    /**
     * @param string $table
     *
     * @return $this
     */
    public function setTable(string $table)
    {
        $this->table = $table;
        
        return $this;
    }
    
    /**
     * @param string $type
     *
     * @return string
     */
    public function varTypePHPDoc(string $type): string
    {
        switch ($type) {
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int':
            case 'integer':
            case 'bigint':
                $ret = 'int';
                break;
            
            case 'float':
            case 'double':
            case 'double precision':
            case 'real':
            case 'decimal':
            case 'numeric':
                $ret = 'float';
                break;
            
            default:
                $ret = 'string';
        }
        
        return $ret;
    }
    
    /**
     * @param $n
     *
     * @return string
     */
    private function eol($n): string
    {
        $ret = '';
        
        for ($i = $n; $i > 0; $i--) {
            $ret .= PHP_EOL;
        }
        
        return $ret;
    }
    
    /**
     * @param $n
     *
     * @return string
     */
    private function idt($n): string
    {
        $ret = '';
        
        for ($i = $n; $i > 0; $i--) {
            $ret .= " ";
        }
        
        return $ret;
    }
    
    /**
     * @param string $txt
     * @param int    $space número de espaços
     * @param int    $eol   número de linhas
     *
     * @return string
     */
    private function line(string $txt, int $space, int $eol): string
    {
        return $this->idt($space) . $txt . $this->eol($eol);
    }
    
    
    /**
     * @return string
     */
    private function writeHead(): string
    {
        $text = "";
        
        $text .= $this->line("<?php", 0, 1);
        $text .= $this->line("/**", 0, 1);
        $text .= $this->line("* Created by Invoker.", 1, 1);
        $text .= $this->line("* Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>", 1, 1);
        $text .= $this->line("* Date: " . date('d/m/Y'), 1, 1);
        $text .= $this->line("* Time: " . date('H:m'), 1, 1);
        $text .= $this->line("*/", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o fechamento da chaves final
     *
     * @return string
     */
    private function writeFoot(): string
    {
        $text = $this->line('}', 0, 0);
        
        $this->write .= $text;
        
        return $text;
    }
}