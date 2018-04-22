<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 12/08/2017
 * Time: 10:39
 */

namespace Pandora\Builder;

class BuilderActions
{
    use BuilderTrait;
    
    private $write = '';
    
    /**
     * Escreve o arquivo
     *
     * @return string
     */
    public function write(): string
    {
        
        $this->writeHead();
        $this->writeUses();
        $this->writeStartClass();
        $this->writeConstruct();
        $this->writeInsert();
        $this->writeUpdate();
        $this->writeDisable();
        $this->writeEnable();
        $this->writeGettersSetters();
        $this->writeFoot();
        
        return $this->write;
    }
    
    private function writeConstruct()
    {
        $obj = $this->getClassName();
        
        $text = "";
        
        $objVar = $this->getNameParameter();
        
        $text .= $this->line("public function __construct(\$container)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$this->setValidation(\$container['validation']);", 8, 1);
        $text .= $this->line("\$this->setDm(\$container['dm_$objVar']);", 8, 1);
        $text .= $this->line("\$this->setConn(\$container['conn']);", 8, 1);
        $text .= $this->line("\$this->set" . $obj . "(\$this->dm->getObject());", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    private function writeDisable()
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function disable()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$id = \$_REQUEST['ipt_id'] ?? '';", 8, 2);
        
        $objVar = $this->getNameParameter();
        $objGet = $this->getClassName();
        
        $text .= $this->line("\$$objVar = \$this->get$objGet();", 8, 1);
        $text .= $this->line("\$" . $objVar . "->setId(\$id);", 8, 2);
        $text .= $this->line("\$dm = \$this->getDm();", 8, 1);
        $text .= $this->line("\$dm->setObject($$objVar);", 8, 2);
        $text .= $this->line("\$op = \$dm->disableById();", 8, 2);
        $text .= $this->line("\$msg = \$op['message'];", 8, 1);
        $text .= $this->line("\$msg .= !empty(\$op['error_info']) ? ' :: ' . \$op['error_info'] : '';", 8, 2);
        $text .= $this->line("return json_encode(\$msg);", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    private function writeEnable()
    {
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function enable()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$id = \$_REQUEST['ipt_id'] ?? '';", 8, 2);
        
        $objVar = $this->getNameParameter();
        $objGet = $this->getClassName();
        
        $text .= $this->line("\$$objVar = \$this->get$objGet();", 8, 1);
        $text .= $this->line("\$" . $objVar . "->setId(\$id);", 8, 2);
        $text .= $this->line("\$dm = \$this->getDm();", 8, 1);
        $text .= $this->line("\$dm->setObject($$objVar);", 8, 2);
        $text .= $this->line("\$op = \$dm->enableById();", 8, 2);
        $text .= $this->line("\$msg = \$op['message'];", 8, 1);
        $text .= $this->line("\$msg .= !empty(\$op['error_info']) ? ' :: ' . \$op['error_info'] : '';", 8, 2);
        $text .= $this->line("return json_encode(\$msg);", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    private function writeGettersSetters()
    {
        $text = "";
        
        //        $text .= $this->line("/**", 4, 1);
        //        $text .= $this->line("* @return mixed", 5, 1);
        //        $text .= $this->line("*/", 5, 1);
        //        $text .= $this->line("private function getConn()", 4, 1);
        //        $text .= $this->line("{", 4, 1);
        //        $text .= $this->line("return \$this->conn;", 8, 1);
        //        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @param \Pandora\Contracts\Connection\iConn \$conn", 5, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return \$this", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private function setConn(iConn \$conn)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$this->conn = \$conn;", 8, 2);
        $text .= $this->line("return \$this;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @return mixed", 5, 1);
        $text .= $this->line("*/private function getDm()", 5, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return \$this->dm;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line(" * @param \Pandora\Contracts\Database\iDataManager \$dm", 4, 1);
        $text .= $this->line(" *", 4, 1);
        $text .= $this->line(" * @return \$this", 4, 1);
        $text .= $this->line(" */", 4, 1);
        $text .= $this->line("private function setDm(iDataManager \$dm)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$this->dm = \$dm;", 8, 2);
        $text .= $this->line("return \$this;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $obj          = $this->getClassName();
        $objVar       = $this->getNameParameter();
        $objNamespace = $this->getNamespace();
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line(" * @return \\APP\\$objNamespace\\$objVar", 4, 1);
        $text .= $this->line(" */", 4, 1);
        $text .= $this->line("private function get" . $obj . "(): $obj", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return \$this->$objVar;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line(" * @param mixed \$$objVar", 4, 1);
        $text .= $this->line(" *", 4, 1);
        $text .= $this->line(" * @return " . $obj . "Actions", 4, 1);
        $text .= $this->line(" */", 4, 1);
        $text .= $this->line("private function set" . $obj . "(\$$objVar)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$this->$objVar = \$$objVar;", 8, 2);
        $text .= $this->line("return \$this;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line(" * @return mixed", 4, 1);
        $text .= $this->line(" */", 4, 1);
        $text .= $this->line("private function getValidation()", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("return \$this->validation;", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line(" * @param \Pandora\Contracts\Validation\iValidation \$validation", 4, 1);
        $text .= $this->line(" *", 4, 1);
        $text .= $this->line(" * @return \$this", 4, 1);
        $text .= $this->line("*/", 4, 1);
        $text .= $this->line("private function setValidation(iValidation \$validation)", 4, 1);
        $text .= $this->line("{", 4, 1);
        $text .= $this->line("\$this->validation = \$validation;", 8, 2);
        $text .= $this->line("return \$this;", 8, 1);
        $text .= $this->line("}", 4, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    private function writeInsert()
    {
        $objVar = $this->getNameParameter();
        $objGet = $this->getClassName();
        
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function insert()", 4, 1);
        $text .= $this->line("{", 4, 1);
        
        $text .= $this->line($this->writeVars('insert'), 0, 1);
        
        //foreach das validações
        $text .= $this->line($this->writeValidation('insert'), 0, 0);
        
        $text .= $this->line("\$error = 0;", 8, 2);
        $text .= $this->line("\$msg = [];", 8, 2);
        $text .= $this->line("foreach (\$check as \$item) {", 8, 1);
        $text .= $this->line("\$error += (\$item['response'] === false) ? 1 : 0;", 12, 2);
        $text .= $this->line("if (!empty(\$item['message'])) {", 12, 1);
        $text .= $this->line("\$msg[] = \$item['message'];", 16, 1);
        $text .= $this->line("}", 12, 2);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("if (\$error < 1) {", 8, 1);
        $text .= $this->line("\$$objVar = \$this->get$objGet();", 12, 2);
        
        //foreach dos setters insert
        $text .= $this->line($this->writeSetters('insert'), 0, 1);
        
        $text .= $this->line("\$dm = \$this->getDm();", 12, 1);
        $text .= $this->line("\$dm->setObject(\$$objVar);", 12, 2);
        $text .= $this->line("\$op = \$dm->insert();", 12, 2);
        $text .= $this->line("\$msg = \$op['message'];", 12, 1);
        $text .= $this->line("\$msg .= !empty(\$op['error_info']) ? ' :: ' . \$op['error_info'] : '';", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("return json_encode(\$msg);", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    private function writeStartClass()
    {
        $text = "";
        
        $obj = $this->getClassName();
        
        $text .= $this->line("class " . $obj . "Actions implements iActions", 0, 1);
        $text .= $this->line("{", 0, 1);
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var \\Pandora\\Contracts\\Connection\\iConn", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$conn;", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var \\Pandora\\Contracts\\Database\\iDataManager", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$dm;", 4, 2);
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var \\Pandora\\Contracts\\Validation\\iValidation", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$validation;", 4, 2);
        
        //$obj    = $this->getClassName() . '\\' . $this->getClassName();
        $objVar = $this->getNameParameter();
        
        $text .= $this->line("/**", 4, 1);
        
        $nms = 'App\\' . $this->getNamespace() . '\\' . $this->getClassName();
        
        $text .= $this->line("* @var \\" . $nms, 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$" . $objVar . ";", 4, 2);
        
        $table = $this->getTable();
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("* @var string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("private \$table = '" . $table . "';", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    private function writeUpdate()
    {
        $objVar = $this->getNameParameter();
        $objGet = $this->getClassName();
        
        $text = "";
        
        $text .= $this->line("/**", 4, 1);
        $text .= $this->line("*", 5, 1);
        $text .= $this->line("* @return string", 5, 1);
        $text .= $this->line("*/", 5, 1);
        $text .= $this->line("public function update()", 4, 1);
        $text .= $this->line("{", 4, 1);
        
        $maxLength = $this->maxLengthVars($this->getFields());
        $space     = $this->space($maxLength['update'] - 2);
        
        $text .= $this->line("\$id" . $space . "= \$_REQUEST['ipt_id'] ?? '';", 8, 1);
        $text .= $this->line($this->writeVars('update'), 0, 1);
        
        //foreach das validações
        $text .= $this->line($this->writeValidation('update'), 0, 1);
        
        $text .= $this->line("\$error = 0;", 8, 2);
        $text .= $this->line("\$msg = [];", 8, 2);
        $text .= $this->line("foreach (\$check as \$item) {", 8, 1);
        $text .= $this->line("\$error += (\$item['response'] === false) ? 1 : 0;", 12, 2);
        $text .= $this->line("if (!empty(\$item['message'])) {", 12, 1);
        $text .= $this->line("\$msg[] = \$item['message'];", 16, 1);
        $text .= $this->line("}", 12, 2);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("if (\$error < 1) {", 8, 1);
        $text .= $this->line("\$$objVar = \$this->get$objGet();", 12, 2);
        
        $objVar = $this->getNameParameter();
        
        //foreach dos setters insert
        $text .= $this->line("\$" . $objVar . "->setId(\$id);", 12, 1);
        $text .= $this->line($this->writeSetters('update'), 0, 1);
        
        $text .= $this->line("\$dm = \$this->getDm();", 12, 2);
        $text .= $this->line("\$dm->setObject(\$$objVar);", 12, 2);
        $text .= $this->line("\$op = \$dm->update();", 12, 2);
        $text .= $this->line("\$msg = \$op['message'];", 12, 1);
        $text .= $this->line("\$msg .= !empty(\$op['error_info']) ? ' :: ' . \$op['error_info'] : '';", 12, 1);
        $text .= $this->line("}", 8, 2);
        $text .= $this->line("return json_encode(\$msg);", 8, 1);
        $text .= $this->line("}", 4, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeUses(): string
    {
        $text = "";
        
        $text .= $this->line("namespace App\Actions;", 0, 2);
        
        $text .= $this->line("use Pandora\\Contracts\\Actions\\iActions;", 0, 1);
        $text .= $this->line("use Pandora\\Contracts\\Connection\\iConn;", 0, 1);
        $text .= $this->line("use Pandora\\Contracts\\Database\\iDataManager;", 0, 1);
        $text .= $this->line("use Pandora\\Contracts\\Validation\\iValidation;", 0, 1);
        
        $nms  = 'App\\' . $this->getNamespace() . '\\' . $this->getClassName();
        $text .= $this->line("use " . $nms . ";", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    protected function writeArgs(array $field, int $lengthMax)
    {
        $validate     = $field['validate'] ?? null;
        $validateRef  = $field['validate_ref'] ?? null;
        $nameFlag     = $field['name_flag'] ?? 'err';
        $nameLength   = $field['name_length'] ?? 0;
        $valueDefault = $field['value_default'] ?? "''";
        
        $length = $lengthMax - $nameLength;
        
        $line = "\$$nameFlag" . $this->space($length) . "= ";
        
        switch ($validate) {
            case 'flag':
                $line .= "isset(\$_REQUEST['ipt_" . $validateRef . "']) ? flag(\$_REQUEST['ipt_" . $validateRef . "']) : $valueDefault;";
                break;
            case 'token_user':
                $line .= "isset(\$_REQUEST['ipt_" . $validateRef . "']) ? token_user('$validateRef', \$_REQUEST['ipt_" . $validateRef . "']) : $valueDefault;";
                break;
            case 'password':
                $line .= "isset(\$_REQUEST['ipt_" . $nameFlag . "']) ? password(\$_REQUEST['ipt_" . $nameFlag . "']) : $valueDefault;";
                break;
            case 'date_automatic':
                $line .= "date('Y-m-d H:i:s');";
                break;
            default:
                $line .= "\$_REQUEST['ipt_$nameFlag'] ?? $valueDefault;";
        }
        
        return $this->line($line, 8, 1);
    }
    
    protected function writeSetters($action)
    {
        $fields = $this->getFields();
        
        $obj = $this->getNameParameter();
        
        $text = '';
        
        $space = 12;
        $eol   = 1;
        
        foreach ($fields as $key => $field) {
            $insert    = isset($field['insert']) ? $field['insert'] : false;
            $update    = isset($field['update']) ? $field['update'] : false;
            $methodSet = isset($field['method_set']) ? $field['method_set'] : 'err';
            
            if ($insert && $action == 'insert') {
                $text .= $this->line("\$" . $obj . "->" . $methodSet . ";", $space, $eol);
            }
            
            if ($update && $action == 'update') {
                $text .= $this->line("\$" . $obj . "->" . $methodSet . ";", $space, $eol);
            }
        }
        
        return $text;
    }
    
    protected function writeValidates(array $field)
    {
        $validate    = $field['validate'] ?? '';
        $validateRef = $field['validate_ref'] ?? '';
        $nameFlag    = $field['name_flag'] ?? 'err';
        $name        = $field['name'] ?? 'err';
        $name_msg    = $field['name_msg'] ?? 'err';
        $isNull      = $field['isnull'] ?? '';
        $indexType   = $field['index_type'] ?? '';
        
        $text = '';
        $nRow = 0;
        
        $textLine = $this->line('// Validação do campo ' . $nameFlag, 0, 1);
        
        if ($isNull == 'NO' && empty($validateRef)) {
            $line = "array_push(\$check, \$validation->isNotEmpty(\$" . $nameFlag . ", '" . $name_msg . "'));";
            
            $textLine .= $this->line($line, 8, 1);
            
            $nRow = 1;
        }
        
        switch ($validate) {
            case 'cnpj':
                $line = "array_push(\$check, \$validation->isCnpj($" . $nameFlag . "));";
                break;
            case 'cpf':
                $line = "array_push(\$check, \$validation->isCpf($" . $nameFlag . "));";
                break;
            case 'email':
                $line = "array_push(\$check, \$validation->isEmail($" . $nameFlag . "));";
                break;
            case 'ip':
                $line = "array_push(\$check, \$validation->isIp($" . $nameFlag . "));";
                break;
            case 'login':
                $line = "array_push(\$check, \$validation->isLogin($" . $nameFlag . "));";
                break;
            case 'mac':
                $line = "array_push(\$check, \$validation->isMac($" . $nameFlag . "));";
                break;
            case 'password':
                $line = "array_push(\$check, \$validation->isPassword($" . $nameFlag . "));";
                break;
            case 'url':
                $line = "array_push(\$check, \$validation->isUrl($" . $nameFlag . "));";
                break;
            default:
                $line = '';
        }
        
        $textLine .= !empty($line) ? $this->line($line, 8, 1) : '';
        
        $nRow = !empty($line) || $nRow == 1 ? 1 : 0;
        
        if (!empty($indexType)) {
            switch ($indexType) {
                case 'UNIQUE':
                    $line = "array_push(\$check, \$validation->isUnique(\$this->conn, \$this->table, '" . $name . "', $" . $nameFlag . "));";
                    break;
                default:
                    $line = "";
                    break;
            }
            
            $textLine .= !empty($line) ? $this->line($line, 8, 1) : '';
            
            $nRow = !empty($line) || $nRow == 1 ? 1 : 0;
        }
        
        $text .= $nRow > 0 ? $this->line($textLine, 8, 1) : '';
        
        return $text;
    }
    
    /**
     * @param string $action
     *
     * @return string
     */
    protected function writeValidation(string $action): string
    {
        $fields = $this->getFields();
        
        $text = "";
        $text .= $this->line("\$validation = \$this->getValidation();", 8, 2);
        //$text .= $this->line("\$conn       = \$this->getConn();", 8, 2);
        $text .= $this->line("\$check = [];", 8, 2);
        
        foreach ($fields as $field) {
            $insert = isset($field['insert']) ? $field['insert'] : false;
            $update = isset($field['update']) ? $field['update'] : false;
            $extra  = $field['extra'] ?? '';
            
            if ($extra != 'auto_increment') {
                if ($insert && $action == 'insert') {
                    $text .= $this->writeValidates($field);
                }
                
                if ($update && $action == 'update') {
                    $text .= $this->writeValidates($field);
                }
            }
        }
        
        return $text;
    }
    
    protected function writeVars(string $action)
    {
        $fields = $this->getFields();
        
        $text = '';
        
        $lengthMax = $this->maxLengthVars($fields);
        
        foreach ($fields as $key => $field) {
            $insert = $field['insert'] ?? false;
            $update = $field['update'] ?? false;
            
            if ($update && $action == 'update') {
                $text .= $this->writeArgs($field, $lengthMax['update']);
            }
            
            if ($insert && $action == 'insert') {
                $text .= $this->writeArgs($field, $lengthMax['insert']);
            }
        }
        
        return $text;
    }
}