<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 28/03/2017
 * Time: 06:31
 */

namespace Invoker\Builder;


class BuilderActionInsert
{
    use BuilderTrait;
    
    /**
     * Escreve o arquivo
     *
     * @return string
     */
    public function write(): string
    {
        $this->writeHead();
        $this->writeUses();
        $this->writeRequests();
        $this->writeValidation();
        $this->writeCheck();
        $this->writeSetters();
        
        return $this->write;
    }
    
    /**
     * @return string
     */
    private function writeUses(): string
    {
        $text = "";
        
        $text .= $this->line("use Amjr\\Invoker\\Validation\\Validation;", 0, 1);
        $text .= $this->line("use " . $this->getNamespace() . ";", 0, 1);
        $text .= $this->line("use " . $this->getNamespace() . "Manager;", 0, 2);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeRequests(): string
    {
        $fields = $this->getFields();
        
        $text = "";
        
        foreach ($fields as $field) {
            $insert      = isset($field['insert']) ? $field['insert'] : false;
            $validate    = isset($field['validate']) ? $field['validate'] : null;
            $validateRef = isset($field['validate_ref']) ? $field['validate_ref'] : null;
            $nameFlag    = isset($field['name_flag']) ? $field['name_flag'] : 'err';
            
            if ($insert) {
                switch ($validate) {
                    case 'flag':
                        $line = "\$$nameFlag = " . "isset(\$_REQUEST['ipt_" . $validateRef . "']) ? flag(\$_REQUEST['ipt_" . $validateRef . "']) : '';";
                        break;
                    case 'token':
                        $line = "\$$nameFlag = " . "isset(\$_REQUEST['ipt_" . $validateRef . "']) ? token(\$_REQUEST['ipt_" . $validateRef . "']) : '';";
                        break;
                    case 'date_automatic':
                        $line = "\$$nameFlag = date('Y-m-d H:i:s');";
                        break;
                    default:
                        $line = "\$$nameFlag = " . "isset(\$_REQUEST['ipt_$nameFlag']) ? \$_REQUEST['ipt_$nameFlag'] : '';";
                }
                
                $text .= $this->line($line, 0, 1);
            }
        }
        
        $text .= $this->line("", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeValidation(): string
    {
        $fields = $this->getFields();
        
        $text = "";
        
        $text .= $this->line("\$validation = new Validation();", 0, 2);
        $text .= $this->line("\$check = [];", 0, 2);
        $text .= $this->line("\$table = '" . $this->getTable() . "';", 0, 2);
        
        foreach ($fields as $field) {
            $insert      = isset($field['insert']) ? $field['insert'] : false;
            $validate    = isset($field['validate']) ? $field['validate'] : '';
            $validateRef = isset($field['validate_ref']) ? $field['validate_ref'] : '';
            $nameFlag    = isset($field['name_flag']) ? $field['name_flag'] : 'err';
            $name        = isset($field['name']) ? $field['name'] : 'err';
            $isNull      = isset($field['isnull']) ? $field['isnull'] : '';
            $indexType   = isset($field['index_type']) ? $field['index_type'] : '';
            
            if ($insert) {
                $nRow = 0;
                
                $textLine = $this->line('// Validação do campo ' . $nameFlag, 0, 1);
                
                if ($isNull == 'NO' && empty($validateRef)) {
                    $line = "array_push(\$check, \$validation->isNotEmpty($" . $nameFlag . ", '" . $nameFlag . "'));";
                    
                    $textLine .= $this->line($line, 0, 1);
                    
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
                
                $textLine .= !empty($line) ? $this->line($line, 0, 1) : '';
                
                $nRow = !empty($line) || $nRow == 1 ? 1 : 0;
                
                if (!empty($indexType)) {
                    switch ($indexType) {
                        case 'UNIQUE':
                            $line = "array_push(\$check, \$validation->isUnique(\$conn, \$table, '" . $name . "', $" . $nameFlag . "));";
                            break;
                        default:
                            $line = "";
                            break;
                    }
                    
                    $textLine .= !empty($line) ? $this->line($line, 0, 1) : '';
                    
                    $nRow = !empty($line) || $nRow == 1 ? 1 : 0;
                }
                
                $text .= $nRow > 0 ? $this->line($textLine, 0, 1) : '';
            }
        }
        
        $text .= $this->line("", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeCheck(): string
    {
        $text = "";
        
        $text .= $this->line("\$error = 0;", 0, 2);
        $text .= $this->line("\$msg = [];", 0, 2);
        $text .= $this->line("foreach (\$check as \$item) {", 0, 1);
        $text .= $this->line("\$error += (\$item['response'] === false) ? 1 : 0;", 4, 2);
        $text .= $this->line("if (!empty(\$item['message'])) {", 4, 1);
        $text .= $this->line("\$msg[] = \$item['message'];", 8, 1);
        $text .= $this->line("}", 4, 1);
        $text .= $this->line("}", 0, 1);
        
        $this->write .= $text;
        
        return $text;
    }
    
    /**
     * @return string
     */
    private function writeSetters(): string
    {
        $fields = $this->getFields();
        
        $obj = $this->getNameParameter();
        
        $className = $this->getClassName();
        
        $text = "";
        
        $text .= $this->line("if (\$error < 1) {", 0, 1);
        $text .= $this->line("\$" . $obj . " = new " . $className . "();", 4, 2);
        
        foreach ($fields as $field) {
            $insert    = isset($field['insert']) ? $field['insert'] : false;
            $methodSet = isset($field['method_set']) ? $field['method_set'] : 'err';
            
            if ($insert) {
                $text .= $this->line("\$" . $obj . "->" . $methodSet . ";", 4, 1);
            }
        }
        
        $text .= $this->line("", 0, 1);
        $text .= $this->line("\$" . $obj . "Manager = new " . $className . "Manager(\$conn, \$user);", 4, 2);
        $text .= $this->line("\$op = \$" . $obj . "Manager->insert();", 4, 2);
        $text .= $this->line("\$msg = \$op['message'];", 4, 1);
        $text .= $this->line("\$msg .= !empty(\$op['error_info']) ? ' :: ' . \$op['error_info'] : '';", 4, 1);
        
        $text .= $this->line("}", 0, 2);
        
        $text .= $this->line("\$ret = json_encode(\$msg);", 0, 2);
        
        $text .= $this->line("echo \$ret;", 0, 0);
        
        $this->write .= $text;
        
        return $text;
    }
}