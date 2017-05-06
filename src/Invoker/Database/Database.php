<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2017
 * Time: 11:16
 */

namespace Invoker\Database;

use Invoker\Connection\Conn;

/**
 * Class Database
 * @package Amjr\Invoker\Database
 */
class Database
{
    /**
     * @var
     */
    private $conn;
    
    /**
     * @var
     */
    private $database;
    
    /**
     * @var
     */
    private $fields;
    
    /**
     * @var
     */
    private $indexes;
    
    /**
     * @var
     */
    private $table;
    
    /**
     * @var
     */
    private $tableInfo;
    
    /**
     * @var
     */
    private $tables;
    
    /**
     * Database constructor.
     *
     * @param \Invoker\Connection\Conn $conn
     * @param string                   $table
     */
    function __construct(Conn $conn, string $table)
    {
        $this->setConn($conn);
        
        $this->setDatabase($conn->getDb());
        $this->setTables($conn);
        
        if (!empty($table)) {
            $this->setTable($table);
            $this->setIndexes($conn);
            $this->setFields($conn);
        }
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
     * @param \Invoker\Connection\Conn $conn
     */
    public function setFields(Conn $conn)
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
        $sql .= "TABLE_NAME = '" . $this->table . "' ";
        $sql .= "AND TABLE_SCHEMA = '" . $this->database . "'";
        
        $result = $conn->query($sql);
        
        $rows = $result->fetchAll(11);
        
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
    }
    
    /**
     * @return mixed
     */
    public function getIndexes()
    {
        return $this->indexes;
    }
    
    /**
     * @param \Invoker\Connection\Conn $conn
     */
    public function setIndexes(Conn $conn)
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
        $sql .= "COL.TABLE_NAME = '" . $this->table . "' ";
        $sql .= "AND COL.TABLE_SCHEMA = '" . $this->database . "' ";
        $sql .= "AND KCU.CONSTRAINT_SCHEMA = COL.TABLE_SCHEMA ";
        $sql .= "AND KCU.TABLE_NAME = COL.TABLE_NAME ";
        $sql .= "AND KCU.COLUMN_NAME = COL.COLUMN_NAME ";
        $sql .= "AND TC.TABLE_NAME = COL.TABLE_NAME ";
        $sql .= "AND TC.CONSTRAINT_SCHEMA = KCU.CONSTRAINT_SCHEMA ";
        $sql .= "AND TC.CONSTRAINT_NAME = KCU.CONSTRAINT_NAME";
        
        $result = $conn->query($sql);
        
        $rows = $result->fetchAll(11);
        
        $indexes = [];
        
        foreach ($rows as $row) {
            $dbColumn = isset($row['name']) ? $row['name'] : '';
            
            $indexes[$dbColumn] = $row;
        }
        
        $this->indexes = $indexes;
    }
    
    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }
    
    /**
     * @param string $table
     */
    public function setTable(string $table)
    {
        $this->table = $table;
    }
    
    /**
     * @return mixed
     */
    public function getTableInfo()
    {
        return $this->tableInfo;
    }
    
    /**
     * @param \Invoker\Connection\Conn $conn
     *
     * @return mixed
     */
    public function setTableInfo(Conn $conn)
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
        $sql .= 'table_schema = "' . $this->database . '" ';
        $sql .= 'AND table_name LIKE "' . $this->table . '"';
        
        $result = $conn->query($sql);
        
        $rows = $result->fetch(11);
        
        return $rows;
    }
    
    /**
     * @return mixed
     */
    public function getTables()
    {
        return $this->tables;
    }
    
    /**
     * @param \Invoker\Connection\Conn $conn
     */
    public function setTables(Conn $conn)
    {
        $sql    = "SHOW TABLES";
        $result = $conn->query($sql);
        $rows   = $result->fetchAll();
        
        $this->tables = $rows;
    }
    
    /**
     * @param Conn $conn
     */
    public function setConn(Conn $conn)
    {
        $this->conn = $conn;
    }
    
    
    /**
     * Retorna o nome do campo sem o prefixo
     *
     * @param $field
     *
     * @return string
     */
    private function fieldNameWithoutPrefix($field)
    {
        $arrNameVar = explode('_', $field);
        
        array_shift($arrNameVar);
        
        $name = implode('_', $arrNameVar);
        
        return $name;
    }
}