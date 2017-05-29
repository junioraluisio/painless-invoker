<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2017
 * Time: 11:16
 */

namespace Pandora\Database;

use Pandora\Connection\Conn;
use Pandora\Utils\Messages;

/**
 * Class Database
 * @package Amjr\Pandora\Database
 */
class Database
{
    /**
     * @var \Pandora\Connection\Conn
     */
    private $conn;
    
    /**
     * @var string
     */
    private $database;
    
    /**
     * @var array
     */
    private $fields;
    
    /**
     * @var array
     */
    private $indexes;
    
    /**
     * @var string
     */
    private $table;
    
    /**
     * @var array
     */
    private $tableInfo;
    
    /**
     * @var array
     */
    private $tables;
    
    /**
     * Database constructor.
     *
     * @param \Pandora\Connection\Conn $conn
     * @param string                   $table
     */
    function __construct(Conn $conn, string $table)
    {
        $this->setConn($conn)
             ->setDatabase($conn->getDb())
             ->setTables($conn);
        
        if (!empty($table)) {
            $this->setTable($table)
                 ->setIndexes($conn)
                 ->setFields($conn);
        }
    }
    
    
    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }
    
    
    /**
     * @param $database
     *
     * @return \Pandora\Database\Database
     */
    public function setDatabase($database): Database
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
     * @param \Pandora\Connection\Conn $conn
     *
     * @return \Pandora\Database\Database
     */
    public function setFields(Conn $conn): Database
    {
        $sql = "SELECT ";
        $sql .= "COLUMN_NAME name, ";
        $sql .= "ORDINAL_POSITION position, ";
        $sql .= "COLUMN_DEFAULT value_default, ";
        $sql .= "IS_NULLABLE isnull, ";
        $sql .= "DATA_TYPE type, ";
        $sql .= "CHARACTER_MAXIMUM_LENGTH length, ";
        $sql .= "NUMERIC_PRECISION numeric_precision, ";
        $sql .= "NUMERIC_SCALE numeric_scale, ";
        $sql .= "DATETIME_PRECISION datetime_precision, ";
        $sql .= "COLLATION_NAME cololation, ";
        $sql .= "COLUMN_KEY field_key, ";
        $sql .= "EXTRA extra, ";
        $sql .= "COLUMN_COMMENT field_comment, ";
        $sql .= "GENERATION_EXPRESSION expression ";
        $sql .= "FROM ";
        $sql .= "INFORMATION_SCHEMA.COLUMNS ";
        $sql .= "WHERE ";
        $sql .= "TABLE_NAME = '" . $this->getTable() . "' ";
        $sql .= "AND TABLE_SCHEMA = '" . $this->getDatabase() . "'";
        
        $result = $conn->query($sql);
        
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        
        $indexes = $this->getIndexes();
        
        $fields = [];
        
        foreach ($rows as $row) {
            $colName = isset($row['name']) ? $row['name'] : '';
            
            $fields[$colName] = $row;
            
            $fields[$colName]['index_name']           = isset($indexes[$colName]['index_name']) ? $indexes[$colName]['index_name'] : null;
            $fields[$colName]['index_type']           = isset($indexes[$colName]['index_type']) ? $indexes[$colName]['index_type'] : null;
            $fields[$colName]['index_ref_schema']     = isset($indexes[$colName]['index_ref_schema']) ? $indexes[$colName]['index_ref_schema'] : null;
            $fields[$colName]['index_ref_table']      = isset($indexes[$colName]['index_ref_table']) ? $indexes[$colName]['index_ref_table'] : null;
            $fields[$colName]['index_ref_column_key'] = isset($indexes[$colName]['index_ref_column_key']) ? $indexes[$colName]['index_ref_column_key'] : null;
            
            $arrComment = json_decode(utf8_encode($row['field_comment']), true);
            
            $fields[$colName]['validate']     = isset($arrComment['validate']) ? $arrComment['validate'] : null;
            $fields[$colName]['validate_ref'] = isset($arrComment['validate_ref']) ? $arrComment['validate_ref'] : null;
            $fields[$colName]['comment']      = isset($arrComment['comment']) ? $arrComment['comment'] : null;
            $fields[$colName]['insert']       = isset($arrComment['insert']) ? $arrComment['insert'] : null;
            $fields[$colName]['update']       = isset($arrComment['update']) ? $arrComment['update'] : null;
            
            $length = !empty($row['length']) ? $row['length'] : $row['numeric_precision'] . ',' . $row['numeric_scale'];
            
            $fields[$colName]['max_length'] = $length;
            
            $name_flag = $this->fieldNameWithoutPrefix($colName);
            
            $fields[$colName]['name_flag']  = $name_flag;
            $fields[$colName]['method_get'] = 'get' . ucfirst($name_flag) . '()';
            $fields[$colName]['method_set'] = 'set' . ucfirst($name_flag) . '($' . $name_flag . ')';
        }
        
        $this->fields = $fields;
        
        return $this;
    }
    
    
    /**
     * @return array
     */
    public function getIndexes(): array
    {
        return $this->indexes;
    }
    
    
    /**
     * @param \Pandora\Connection\Conn $conn
     *
     * @return \Pandora\Database\Database
     */
    public function setIndexes(Conn $conn): Database
    {
        $sql = "SELECT ";
        $sql .= "COL.COLUMN_NAME name, ";
        $sql .= "COL.ORDINAL_POSITION position, ";
        $sql .= "COL.COLUMN_DEFAULT value_default, ";
        $sql .= "COL.IS_NULLABLE isnull, ";
        $sql .= "COL.DATA_TYPE type, ";
        $sql .= "COL.CHARACTER_MAXIMUM_LENGTH length, ";
        $sql .= "COL.NUMERIC_PRECISION numeric_precision, ";
        $sql .= "COL.NUMERIC_SCALE numeric_scale, ";
        $sql .= "COL.DATETIME_PRECISION datetime_precision, ";
        $sql .= "COL.COLLATION_NAME cololation, ";
        $sql .= "COL.COLUMN_KEY field_key, ";
        $sql .= "COL.EXTRA extra, ";
        $sql .= "COL.COLUMN_COMMENT field_comment, ";
        $sql .= "COL.GENERATION_EXPRESSION expression, ";
        $sql .= "KCU.CONSTRAINT_NAME index_name, ";
        $sql .= "TC.CONSTRAINT_TYPE index_type, ";
        $sql .= "KCU.POSITION_IN_UNIQUE_CONSTRAINT index_posunique, ";
        $sql .= "KCU.REFERENCED_TABLE_SCHEMA index_ref_schema, ";
        $sql .= "KCU.REFERENCED_TABLE_NAME index_ref_table, ";
        $sql .= "KCU.REFERENCED_COLUMN_NAME index_ref_column_key ";
        $sql .= "FROM ";
        $sql .= "INFORMATION_SCHEMA.COLUMNS COL, ";
        $sql .= "INFORMATION_SCHEMA.KEY_COLUMN_USAGE KCU, ";
        $sql .= "INFORMATION_SCHEMA.TABLE_CONSTRAINTS TC ";
        $sql .= "WHERE ";
        $sql .= "COL.TABLE_NAME = '" . $this->getTable() . "' ";
        $sql .= "AND COL.TABLE_SCHEMA = '" . $this->getDatabase() . "' ";
        $sql .= "AND KCU.CONSTRAINT_SCHEMA = COL.TABLE_SCHEMA ";
        $sql .= "AND KCU.TABLE_NAME = COL.TABLE_NAME ";
        $sql .= "AND KCU.COLUMN_NAME = COL.COLUMN_NAME ";
        $sql .= "AND TC.TABLE_NAME = COL.TABLE_NAME ";
        $sql .= "AND TC.CONSTRAINT_SCHEMA = KCU.CONSTRAINT_SCHEMA ";
        $sql .= "AND TC.CONSTRAINT_NAME = KCU.CONSTRAINT_NAME";
        
        $result = $conn->query($sql);
        
        $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
        
        $indexes = [];
        
        foreach ($rows as $row) {
            $dbColumn = isset($row['name']) ? $row['name'] : '';
            
            $indexes[$dbColumn] = $row;
        }
        
        $this->indexes = $indexes;
        
        return $this;
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
     * @return \Pandora\Database\Database
     */
    public function setTable(string $table): Database
    {
        $tables = $this->getTables();
        
        if (!in_array($table, $tables)) {
            Messages::exception('The table does not exist in the database!', 1, 2);
        }
        
        $this->table = $table;
        
        return $this;
    }
    
    
    /**
     * @return array
     */
    public function getTableInfo(): array
    {
        return $this->tableInfo;
    }
    
    
    /**
     * @param \Pandora\Connection\Conn $conn
     *
     * @return array
     */
    public function setTableInfo(Conn $conn): array
    {
        $sql = 'SELECT ';
        $sql .= 'TABLE_COMMENT tbl_comment, ';
        $sql .= 'TABLE_NAME tbl_name, ';
        $sql .= 'AUTO_INCREMENT tbl_auto_increment, ';
        $sql .= 'CREATE_TIME tbl_create, ';
        $sql .= 'UPDATE_TIME tbl_update, ';
        $sql .= 'TABLE_COMMENT tbl_comment ';
        $sql .= 'FROM ';
        $sql .= 'INFORMATION_SCHEMA.TABLES ';
        $sql .= 'WHERE ';
        $sql .= 'table_schema = "' . $this->getDatabase() . '" ';
        $sql .= 'AND table_name LIKE "' . $this->getTable() . '"';
        
        $result = $conn->query($sql);
        
        $rows = $result->fetch(\PDO::FETCH_ASSOC);
        
        return $rows;
    }
    
    
    /**
     * @return array
     */
    public function getTables(): array
    {
        return $this->tables;
    }
    
    
    /**
     * @param \Pandora\Connection\Conn $conn
     *
     * @return \Pandora\Database\Database
     */
    public function setTables(Conn $conn): Database
    {
        $sql    = "SHOW TABLES";
        $result = $conn->query($sql);
        $rows   = $result->fetchAll(\PDO::FETCH_COLUMN);
        
        $this->tables = $rows;
        
        return $this;
    }
    
    
    /**
     * @param \Pandora\Connection\Conn $conn
     *
     * @return \Pandora\Database\Database
     */
    public function setConn(Conn $conn): Database
    {
        $this->conn = $conn;
        
        return $this;
    }
    
    
    /**
     * @param $field
     *
     * @return string
     */
    private function fieldNameWithoutPrefix($field): string
    {
        $arrNameVar = explode('_', $field);
        
        array_shift($arrNameVar);
        
        $name = implode('_', $arrNameVar);
        
        return $name;
    }
}