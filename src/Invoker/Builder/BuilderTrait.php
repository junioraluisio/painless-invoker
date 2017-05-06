<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 25/03/2017
 * Time: 07:16
 */

namespace Invoker\Builder;

use Invoker\Database\Database;

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
     * @var string com o prefixo que compõe o nome dos campos
     */
    private $prefix;
    
    /**
     * @var string com o nome da tabela
     */
    private $table;
    
    /**
     * @var string
     */
    private $write = "";
    
    /**
     * BuilderTrait constructor.
     *
     * @param \Invoker\Database\Database|null $database
     */
    function __construct(Database $database = null)
    {
        if($database !== null) {
            $this->setDatabase($database);
            $this->setTable($database->getTable());
            $this->setNamespace();
            $this->setClassName();
            $this->setNameParameter();
            $this->setFields($database->getFields());
            $this->setPrefix();
        }
    }
    
    /**
     * @return mixed
     */
    public function getClassName()
    {
        $arrTableName = explode('_', $this->table);
        
        $count = count($arrTableName);
        
        $className = '';
        
        for ($i = 1; $i <= $count; $i++) {
            $subName = isset($arrTableName[$i]) ? $arrTableName[$i] : '';
            
            $className .= ucfirst($subName);
        }
        
        $this->className = $className;
        
        return $className;
    }
    
    /**
     * @return string
     */
    public function setClassName()
    {
        $arrTableName = explode('_', $this->table);
        
        $count = count($arrTableName);
        
        $className = '';
        
        for ($i = 1; $i <= $count; $i++) {
            $subName = isset($arrTableName[$i]) ? $arrTableName[$i] : '';
            
            $className .= ucfirst($subName);
        }
        
        $this->className = $className;
        
        return $className;
    }
    
    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->database;
    }
    
    /**
     * @param mixed $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }
    
    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * @param mixed $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    
    /**
     * @return mixed
     */
    public function getNameParameter()
    {
        return $this->nameParameter;
    }
    
    /**
     * @return string
     */
    public function setNameParameter()
    {
        $arrTableName = explode('_', $this->table);
        
        $count = count($arrTableName);
        
        $nameParameter = '';
        
        for ($i = 1; $i <= $count; $i++) {
            $subName = isset($arrTableName[$i]) ? $arrTableName[$i] : '';
            
            $nameParameter .= $subName;
        }
        
        $this->nameParameter = $nameParameter;
        
        return $nameParameter;
    }
    
    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    /**
     * @return string
     */
    public function setNamespace()
    {
        $arrTableName = explode('_', $this->table);
        
        $tableName = isset($arrTableName[0]) ? ucfirst($arrTableName[0]) : '::ERROR::';
        
        $namespace = 'App\\' . $tableName . '\\' . $this->getClassName();
        
        $this->namespace = $namespace;
        
        return $namespace;
    }
    
    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
    
    /**
     * @return string
     */
    public function setPrefix()
    {
        $keys = array_keys($this->fields);
        
        $arrNameVar = explode('_', $keys[0]);
        
        $prefix = array_shift($arrNameVar) . '_';
        
        $this->prefix = $prefix;
        
        return $prefix;
    }
    
    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }
    
    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }
    
    /**
     * @param $type
     *
     * @return string
     */
    public function varTypePHPDoc($type)
    {
        switch ($type) {
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int':
            case 'integer':
            case 'bigint':
                $ret = 'integer';
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
    private function eol($n)
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
    private function idt($n)
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
    private function line(string $txt, int $space, int $eol)
    {
        return $this->idt($space) . $txt . $this->eol($eol);
    }
    
    
    
    /**
     * @return string
     */
    private function writeHead()
    {
        $text = "";
        
        $text .= $this->line("<?php", 0, 1);
        $text .= $this->line("/**", 0, 1);
        $text .= $this->line("* Created by Factory.", 1, 1);
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
    private function writeFoot()
    {
        $text = $this->line('}', 0, 0);
        
        $this->write .= $text;
        
        return $text;
    }
}