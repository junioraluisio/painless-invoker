<?php
/**
 * Created by PhpStorm.
 * D: Junior
 * Date: 11/03/2017
 * Time: 10:26
 */

namespace Invoker\Builder;

class BuilderClassManager
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
        $this->writeMethodConstruct();
        $this->writeMethodFindAll();
        $this->writeMethodFindById();
        $this->writeMethodInsert();
        $this->writeMethodUpdate();
        $this->writeMethodDisableById();
        $this->writeMethodEnableById();
        $this->writeMethodExtractData();
        $this->writeMethodPrefix();
        $this->writeMethodRenameFields();
        $this->writeMethodStatement();
        $this->writeMethodClearPrefix();
        $this->writeFoot();
        
        return $this->write;
    }
    
    /**
     * Escreve os atributos
     *
     * @return string
     */
    private function writeAttributes(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var \Invoker\Connection\Conn", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$conn;", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$prefix = '" . $this->prefix . "';", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$table  = '" . $this->table . "';", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var \\App\\Auth\\" . $this->getClassName() . "\\" . $this->getClassName(), 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$" . $this->getNameParameter() . ";", 4, 2);
        
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
        
        $text .= $this->line("class " . $this->className . "Manager", 0, 1);
        $text .= $this->line("{", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método clearPrefix()
     *
     * @return string
     */
    private function writeMethodClearPrefix(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param \$field", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private function clearPrefix(\$field)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return str_replace(\$this->prefix, '', \$field);", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método __construct()
     *
     * @return string
     */
    private function writeMethodConstruct(): string
    {
        $className     = $this->getClassName();
        $nameParameter = $this->getNameParameter();
        
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* UserManager constructor.", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @param \\Invoker\\Connection\\Conn \$conn", 5, 1);
        $text .= $this->line("* @param \\App\\Auth\\" . $className . "\\" . $className . "  \$" . $nameParameter, 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("function __construct(Conn \$conn, " . $className . " \$" . $nameParameter . ")", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$this->conn = \$conn;", 8, 2);
        $text .= $this->line("\$this->" . $nameParameter . "= \$" . $nameParameter . ";", 8, 1);
        $text .= $this->line("}", 4, 2);
        
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
        $nameParameter = $this->getNameParameter();
        
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return mixed", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function disableById()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$id = \$this->" . $nameParameter . "->getId();", 8, 2);
        $text .= $this->line("\$sql = 'UPDATE ' . \$this->table;", 8, 1);
        $text .= $this->line("\$sql .= ' SET ';", 8, 1);
        $text .= $this->line("\$sql .= \$this->prefix('condition') . ' = \"B\"';", 8, 1);
        $text .= $this->line("\$sql .= ' WHERE ';", 8, 1);
        $text .= $this->line("\$sql .= \$this->prefix('id') . ' = \"' . \$id . '\"';", 8, 2);
        $text .= $this->line("\$stmt = \$this->conn->prepare(\$sql);", 8, 2);
        $text .= $this->line("\$error = \$stmt->errorInfo();", 8, 2);
        $text .= $this->line("if (\$stmt->execute()) {", 8, 1);
        $text .= $this->line("\$ret['response'] = true;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'Registro desabilitado com sucesso!';", 12, 1);
        $text .= $this->line("} else {", 8, 1);
        $text .= $this->line("\$ret['response'] = false;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'Ocorreu um erro ao tentar desabilitar o registro';", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("\$ret['error_info'] = isset(\$error[2]) ? \$error[0] . ' - ' . \$error[2] : '';", 8, 2);
        $text .= $this->line("return \$ret;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
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
        $text .= $this->line("* @return mixed", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function enableById()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$id = \$this->" . $this->getNameParameter() . "->getId();", 8, 2);
        $text .= $this->line("\$sql = 'UPDATE ' . \$this->table;", 8, 1);
        $text .= $this->line("\$sql .= ' SET ';", 8, 1);
        $text .= $this->line("\$sql .= \$this->prefix('condition') . ' = \"A\"';", 8, 1);
        $text .= $this->line("\$sql .= ' WHERE ';", 8, 1);
        $text .= $this->line("\$sql .= \$this->prefix('id') . ' = \"' . \$id . '\"';", 8, 2);
        $text .= $this->line("\$stmt = \$this->conn->prepare(\$sql);", 8, 2);
        $text .= $this->line("\$error = \$stmt->errorInfo();", 8, 2);
        $text .= $this->line("if (\$stmt->execute()) {", 8, 1);
        $text .= $this->line("\$ret['response'] = true;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'Registro habilitado com sucesso!';", 12, 1);
        $text .= $this->line("} else {", 8, 1);
        $text .= $this->line("\$ret['response'] = false;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'Ocorreu um erro ao tentar habilitar o registro';", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("\$ret['error_info'] = isset(\$error[2]) ? \$error[0] . ' - ' . \$error[2] : '';", 8, 2);
        $text .= $this->line("return \$ret;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método extractData()
     *
     * @return string
     */
    private function writeMethodExtractData(): string
    {
        $fields = $this->getFields();
        
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private function extractData()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$data = [];", 8, 2);
        
        foreach ($fields as $key => $field) {
            $validate      = $field['validate'];
            $nameFlag      = $field['name_flag'];
            $methodGet     = $field['method_get'];
            $nameParameter = $this->getNameParameter();
            
            $text .= $this->line("if(\$this->" . $nameParameter . "->" . $methodGet . "!== null){", 8, 1);
            
            switch ($validate) {
                case 'password':
                    $text .= $this->line("\$data[\$this->prefix('" . $nameFlag . "')] = password_hash(\$this->" . $nameParameter . "->" . $methodGet . ", PASSWORD_DEFAULT);", 12, 1);
                    break;
                default:
                    $text .= $this->line("\$data[\$this->prefix('" . $nameFlag . "')] = \$this->" . $nameParameter . "->" . $methodGet . ";", 12, 1);
                
            }
            
            $text .= $this->line("}", 8, 2);
        }
        
        $text .= $this->line("return \$data;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método findAll()
     *
     * @return string
     */
    private function writeMethodFindAll(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param string \$fields", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function findAll(\$fields = '*')", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$sql = 'SELECT ' . \$this->renameFields(\$fields);", 8, 1);
        $text .= $this->line("\$sql .= ' FROM ' . \$this->table;", 8, 2);
        $text .= $this->line("\$result = \$this->conn->query(\$sql);", 8, 2);
        $text .= $this->line("return \$result->fetchAll();", 8, 1);
        $text .= $this->line("}", 4, 2);
        
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
        $text .= $this->line("* @return mixed", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function findById(\$id)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$sql = 'SELECT * ';", 8, 1);
        $text .= $this->line("\$sql .= ' FROM ' . \$this->table;", 8, 1);
        $text .= $this->line("\$sql .= ' WHERE ' . \$this->prefix('id') . ' = \"' . \$id . '\"';", 8, 2);
        $text .= $this->line("\$result = \$this->conn->query(\$sql);", 8, 2);
        $text .= $this->line("return \$result->fetchAll();", 8, 1);
        $text .= $this->line("}", 4, 2);
        
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
        $text .= $this->line("* @return mixed", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function insert()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$data = \$this->extractData();", 8, 2);
        $text .= $this->line("\$fields = array_keys(\$data);", 8, 2);
        $text .= $this->line("\$sql = 'INSERT INTO ' . \$this->table;", 8, 1);
        $text .= $this->line("\$sql .= ' (' . implode(', ', \$fields) . ') ';", 8, 1);
        $text .= $this->line("\$sql .= 'VALUES';", 8, 1);
        $text .= $this->line("\$sql .= ' (';", 8, 2);
        $text .= $this->line("\$values = [];", 8, 2);
        $text .= $this->line("foreach (\$fields as \$field) {", 8, 1);
        $text .= $this->line("\$values[] = ':' . \$this->clearPrefix(\$field);", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("\$sql .= implode(', ', \$values);", 8, 1);
        $text .= $this->line("\$sql .= ')';", 8, 2);
        $text .= $this->line("\$stmt = \$this->statement(\$sql, \$data);", 8, 2);
        $text .= $this->line("if (\$stmt['execute']) {", 8, 1);
        $text .= $this->line("\$ret['response'] = true;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'Registro inserido com sucesso!';", 12, 1);
        $text .= $this->line("} else {", 8, 1);
        $text .= $this->line("\$ret['response'] = false;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'Ocorreu um erro ao inserir o registro';", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("\$error = \$stmt['errorInfo'];", 8, 2);
        $text .= $this->line("\$ret['error_info'] = isset(\$error[2]) ? \$error[0] . ' - ' . \$error[2] : '';", 8, 2);
        $text .= $this->line("return \$ret;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método prefix()
     *
     * @return string
     */
    private function writeMethodPrefix(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param \$field", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private function prefix(\$field)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return \$this->prefix . \$field;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método renameFields()
     *
     * @return string
     */
    private function writeMethodRenameFields(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param \$fields", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private function renameFields(\$fields)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$ret = '*';", 8, 2);
        $text .= $this->line("if (is_array(\$fields)) {", 8, 1);
        $text .= $this->line("\$count = count(\$fields);", 12, 2);
        $text .= $this->line("if (\$count > 0) {", 12, 1);
        $text .= $this->line("\$arrFields = [];", 16, 2);
        $text .= $this->line("foreach (\$fields as \$field) {", 16, 1);
        $text .= $this->line("\$arrFields[] = \$this->prefix(\$field);", 20, 1);
        $text .= $this->line("}", 16, 2);
        $text .= $this->line("\$ret = implode(',', \$arrFields);", 16, 1);
        $text .= $this->line("}", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("return \$ret;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * Escreve o método statement()
     *
     * @return string
     */
    private function writeMethodStatement(): string
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param string \$sql", 5, 1);
        $text .= $this->line("* @param array \$data", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return array", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private function statement(\$sql, \$data)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$stmt = \$this->conn->prepare(\$sql);", 8, 2);
        $text .= $this->line("foreach (\$data as \$key => \$value) {", 8, 1);
        $text .= $this->line("if(\$value !== null) {", 12, 1);
        $text .= $this->line("\$stmt->bindValue(':' . \$this->clearPrefix(\$key), \$value);", 16, 1);
        $text .= $this->line("}", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("\$ret['execute']   = \$stmt->execute();", 8, 1);
        $text .= $this->line("\$ret['errorInfo'] = \$stmt->errorInfo();", 8, 2);
        $text .= $this->line("return \$ret;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
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
        $text .= $this->line("* @return mixed", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function update()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("/* \$data keys should correspond to valid Table columns on the Database */", 8, 1);
        $text .= $this->line("\$data = \$this->extractData();", 8, 2);
        $text .= $this->line("\$id = \$this->" . $this->getNameParameter() . "->getId();", 8, 2);
        $text .= $this->line("/* if no ID specified create new user else update the one in the Database */", 8, 1);
        $text .= $this->line("if (!empty(\$id)) {", 8, 1);
        $text .= $this->line("\$fields = array_keys(\$data);", 12, 2);
        $text .= $this->line("\$sql = 'UPDATE ' . \$this->table;", 12, 1);
        $text .= $this->line("\$sql .= ' SET ';", 12, 2);
        $text .= $this->line("\$set = [];", 12, 2);
        $text .= $this->line("foreach (\$fields as \$field) {", 12, 1);
        $text .= $this->line("\$set[] = \$field . ' = :' . \$this->clearPrefix(\$field);", 16, 1);
        $text .= $this->line("}", 12, 2);
        $text .= $this->line("\$sql .= implode(', ', \$set);", 12, 1);
        $text .= $this->line("\$sql .= ' WHERE ';", 12, 1);
        $text .= $this->line("\$sql .= \$this->prefix('id') . ' = \"' . \$id . '\"';", 12, 2);
        $text .= $this->line("\$stmt = \$this->statement(\$sql, \$data);", 12, 2);
        $text .= $this->line("\$error = \$stmt['errorInfo'];", 12, 2);
        $text .= $this->line("if (\$stmt['execute']) {", 12, 1);
        $text .= $this->line("\$ret['response'] = true;", 16, 1);
        $text .= $this->line("\$ret['message']  = 'Registro atualizado com sucesso!';", 16, 1);
        $text .= $this->line("} else {", 12, 1);
        $text .= $this->line("\$ret['response'] = false;", 16, 1);
        $text .= $this->line("\$ret['message']  = 'Ocorreu um erro ao tentar atualizar o registro';", 16, 1);
        $text .= $this->line("}", 12, 2);
        $text .= $this->line("\$ret['error_info'] = isset(\$error[2]) ? \$error[0] . ' - ' . \$error[2] : '';", 12, 1);
        $text .= $this->line("} else {", 8, 1);
        $text .= $this->line("\$ret['response'] = false;", 12, 1);
        $text .= $this->line("\$ret['message']  = 'O ID não foi informado!';", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("return \$ret;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
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
        
        $text .= $this->line("namespace " . $this->getNamespace() . ";", 0, 2);
        $text .= $this->line("use Invoker\\Connection\\Conn;", 0, 3);
        
        $this->write .= $text;
        
        return $text;
    }
}