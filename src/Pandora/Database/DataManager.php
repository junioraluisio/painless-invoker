<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 30/05/2017
 * Time: 10:05
 */

namespace Pandora\Database;


use Pandora\Connection\Conn;
use Pandora\Contracts\Database\iDataManager;
use Pandora\Contracts\Database\iDataObject;

/**
 * Class DataManager
 * @package Pandora\Database
 */
class DataManager implements iDataManager
{
    /**
     * @var \Pandora\Connection\Conn
     */
    private $conn;
    
    /**
     * @var \Pandora\Contracts\Database\iDataObject
     */
    private $object;
    
    /**
     * DataManager constructor.
     *
     * @param \Pandora\Connection\Conn                $conn
     * @param \Pandora\Contracts\Database\iDataObject $object
     */
    function __construct(Conn $conn, iDataObject $object)
    {
        $this->setConn($conn)
             ->setObject($object);
    }
    
    /**
     * @param string $fields
     *
     * @return array
     */
    public function all($fields = '*'): array
    {
        $sql = 'SELECT ' . $this->renameFields($fields);
        $sql .= ' FROM ' . $this->object->getTable();
        
        $result = $this->conn->query($sql);
        
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * @return array
     */
    public function disableById(): array
    {
        $sql = 'UPDATE ' . $this->object->getTable();
        $sql .= ' SET ';
        $sql .= $this->addPrefix('condition') . ' = "B"';
        $sql .= ' WHERE ';
        $sql .= $this->addPrefix('id') . ' = "' . $this->object->getId() . '"';
        
        $stmt = $this->conn->prepare($sql);
        
        $error = $stmt->errorInfo();
        
        if ($stmt->execute()) {
            $ret['response'] = true;
            $ret['message']  = 'Registro desabilitado com sucesso!';
        } else {
            $ret['response'] = false;
            $ret['message']  = 'Ocorreu um erro ao tentar desabilitar o registro';
        }
        
        $ret['error_info'] = isset($error[2]) ? $error[0] . ' - ' . $error[2] : '';
        
        return $ret;
    }
    
    /**
     * @return array
     */
    public function enableById(): array
    {
        $sql = 'UPDATE ' . $this->object->getTable();
        $sql .= ' SET ';
        $sql .= $this->addPrefix('condition') . ' = "A"';
        $sql .= ' WHERE ';
        $sql .= $this->addPrefix('id') . ' = "' . $this->object->getId() . '"';
        
        $stmt = $this->conn->prepare($sql);
        
        $error = $stmt->errorInfo();
        
        if ($stmt->execute()) {
            $ret['response'] = true;
            $ret['message']  = 'Registro habilitado com sucesso!';
        } else {
            $ret['response'] = false;
            $ret['message']  = 'Ocorreu um erro ao tentar habilitar o registro';
        }
        
        $ret['error_info'] = isset($error[2]) ? $error[0] . ' - ' . $error[2] : '';
        
        return $ret;
    }
    
    /**
     * @param array $fieldsValues
     * @param int   $limit
     *
     * @return array
     */
    public function findByFieldsValues(array $fieldsValues, int $limit): array
    {
        $sql = 'SELECT *';
        $sql .= ' FROM ' . $this->object->getTable();
        $sql .= ' WHERE ' . $this->addPrefix('condition') . ' = "A"';
        
        foreach ($fieldsValues as $field => $value) {
            $sql .= ' AND ' . $this->addPrefix($field) . ' = "' . $value . '"';
        }
        
        $sql .= ($limit > 0) ? ' LIMIT ' . $limit : '';
        
        $result = $this->conn->query($sql);
        
        $ret = ($limit == 1) ? $result->fetch(\PDO::FETCH_ASSOC) : $result->fetchAll(\PDO::FETCH_ASSOC);
        
        return !($ret) ? [] : $ret;
    }
    
    /**
     * @param string $id
     *
     * @return array
     */
    public function findById($id): array
    {
        $sql = 'SELECT * ';
        $sql .= ' FROM ' . $this->object->getTable();
        $sql .= ' WHERE ' . $this->addPrefix('id') . ' = "' . $id . '"';
        $sql .= ' LIMIT 1';
        
        $result = $this->conn->query($sql);
        
        return $result->fetch();
    }
    
    /**
     * @param array $fieldsValues
     *
     * @return bool
     */
    public function findUnique(array $fieldsValues): bool
    {
        $sql = 'SELECT *';
        $sql .= ' FROM ' . $this->object->getTable();
        $sql .= ' WHERE ' . $this->addPrefix('condition') . ' = "A"';
        
        foreach ($fieldsValues as $field => $value) {
            $sql .= ' AND ' . $this->addPrefix($field) . ' = "' . $value . '"';
        }
        
        $sql .= ' LIMIT 1';
        
        $result = $this->conn->query($sql);
        
        $ret = $result->fetch(\PDO::FETCH_ASSOC);
        
        return count($ret) > 0 ? true : false;
    }
    
    /**
     * @param array $fieldsValues
     *
     * @return array
     */
    public function insert(array $fieldsValues): array
    {
        $fields = array_keys($fieldsValues);
        
        $sql = 'INSERT INTO ' . $this->object->getTable();
        $sql .= ' (' . implode(', ', $fields) . ') ';
        $sql .= 'VALUES';
        $sql .= ' (';
        
        $values = [];
        
        foreach ($fields as $field) {
            $values[] = ':' . $field;
        }
        
        $sql .= implode(', ', $values);
        $sql .= ')';
        
        $stmt = $this->statement($sql, $fieldsValues);
        
        if ($stmt['execute']) {
            $ret['response'] = true;
            $ret['message']  = 'Registro inserido com sucesso!';
        } else {
            $ret['response'] = false;
            $ret['message']  = 'Ocorreu um erro ao inserir o registro';
        }
        
        $error = $stmt['errorInfo'];
        
        $ret['error_info'] = isset($error[2]) ? $error[0] . ' - ' . $error[2] : '';
        
        return $ret;
    }
    
    /**
     * @return array
     */
    public function update(): array
    {
        /* $data keys should correspond to valid Table columns on the Database */
        $data = $this->extractData();
        
        /* if no ID specified create new user else update the one in the Database */
        if (!empty($this->object->getId())) {
            $fields = array_keys($data);
            
            $sql = 'UPDATE ' . $this->object->getTable();
            $sql .= ' SET ';
            
            $set = [];
            
            foreach ($fields as $field) {
                $set[] = $field . ' = :' . $this->clearPrefix($field);
            }
            
            $sql .= implode(', ', $set);
            $sql .= ' WHERE ';
            $sql .= $this->addPrefix('id') . ' = "' . $this->object->getId() . '"';
            
            $stmt = $this->statement($sql, $data);
            
            $error = $stmt['errorInfo'];
            
            if ($stmt['execute']) {
                $ret['response'] = true;
                $ret['message']  = 'Registro atualizado com sucesso!';
            } else {
                $ret['response'] = false;
                $ret['message']  = 'Ocorreu um erro ao tentar atualizar o registro';
            }
            
            $ret['error_info'] = isset($error[2]) ? $error[0] . ' - ' . $error[2] : '';
        } else {
            $ret['response'] = false;
            $ret['message']  = 'O ID não foi informado!';
        }
        
        return $ret;
    }
    
    /**
     * @param $field
     *
     * @return string
     */
    private function addPrefix($field): string
    {
        return $this->object->getPrefix() . $field;
    }
    
    /**
     * @param $field
     *
     * @return string
     */
    private function clearPrefix($field): string
    {
        return str_replace($this->object->getPrefix()(), '', $field);
    }
    
    /**
     * @return array
     */
    private function extractData(): array
    {
        $data = [];
        
        $methodsGet = $this->extractMethodsGet();
        
        foreach ($methodsGet as $key => $method) {
            try {
                if (!is_null($this->object->{$method}())) {
                    $data[$this->addPrefix($key)] = $this->object->{$method}();
                }
            } catch (\Exception $e) {
                echo 'Exception caught: ', $e->getMessage(), "\n";
            }
        }
        
        return $data;
    }
    
    private function extractMethodsGet()
    {
        $methods = get_class_methods($this->object);
        
        $methodsGets = [];
        
        foreach ($methods as $method) {
            $pos = strpos($method, 'get');
            
            if ($pos !== false) {
                $key = strtolower(str_replace('get', '', $method));
                
                $methodsGets[$key] = $method;
            }
        }
        
        return $methodsGets;
    }
    
    /**
     * @param $fields
     *
     * @return string
     */
    private function renameFields($fields): string
    {
        $ret = '*';
        
        if (is_array($fields)) {
            $count = count($fields);
            
            if ($count > 0) {
                $arrFields = [];
                
                foreach ($fields as $field) {
                    $arrFields[] = $this->addPrefix($field);
                }
                
                $ret = implode(',', $arrFields);
            }
        }
        
        return $ret;
    }
    
    /**
     * @param \Pandora\Connection\Conn $conn
     *
     * @return DataManager
     */
    private function setConn(Conn $conn): DataManager
    {
        $this->conn = $conn;
        
        return $this;
    }
    
    /**
     * @param $object
     *
     * @return DataManager
     */
    private function setObject($object): DataManager
    {
        $this->object = $object;
        
        return $this;
    }
    
    /**
     * @param string $sql
     * @param array  $data
     *
     * @return array
     */
    private function statement($sql, $data): array
    {
        $stmt = $this->conn->prepare($sql);
        
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $stmt->bindValue(':' . $this->clearPrefix($key), $value);
            }
        }
        
        $ret['execute']   = $stmt->execute();
        $ret['errorInfo'] = $stmt->errorInfo();
        
        return $ret;
    }
}