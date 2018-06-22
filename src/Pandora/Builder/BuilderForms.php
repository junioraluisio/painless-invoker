<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 22/04/2018
 * Time: 14:00
 */

namespace Pandora\Builder;


class BuilderForms
{
    use BuilderTrait;
    
    private $write = '';
    
    /**
     * @param $action
     *
     * @return string
     */
    public function write($action): string
    {
        $this->writeForm($action);
        
        return $this->write;
    }
    
    /**
     * @param string $action
     *
     * @return string
     */
    public function writeForm(string $action)
    {
        $fields = $this->getFields();
        
        $text = "";
        
        $text .= $this->line('<form class="form">', 0, 1);
        
        foreach ($fields as $field) {
            $insert = $field['insert'] ?? false;
            $update = $field['update'] ?? false;
            
            if ($insert && $action == 'insert') {
                $text .= $this->writeField($field);
            }
            
            if ($update && $action == 'update') {
                $text .= $this->writeField($field);
            }
        }
        
        $obj = $this->getClassName();
        
        $text .= $this->line('<button type="button" id="btnRecord' . $obj . '" class="btn btn-primary">Gravar</button>',4,1);
        
        $text .= $this->line('</form>', 0, 0);
        
        $this->write .= $text;
        
        return $text;
    }
    
    protected function writeField($field)
    {
        $validate = $field['validate'] ?? '';
        $name_msg = utf8_decode($field['name_msg']) ?? 'err';
        $nameId   = $field['name_flag'] ?? 'err';
        
        $name = 'ipt_' . $nameId;
        $id   = 'ipt' . ucfirst($nameId);
        
        $line = $this->line("<div class='form-group'>", 4, 1);
        
        $line .= $this->line("<label for='$id'>$name_msg</label>", 8, 1);
        
        switch ($validate) {
            case 'email':
                $type  = 'email';
                $class = 'form-control isEmail';
                break;
            case 'integer':
                $type  = 'number';
                $class = 'form-control isNumber';
                break;
            case 'password':
                $type  = 'password';
                $class = 'form-control isPassword';
                break;
            case 'date':
                $type  = 'date';
                $class = 'form-control isDate';
                break;
            case 'url':
                $type  = 'url';
                $class = 'form-control isUrl';
                break;
            default:
                $type  = 'text';
                $class = 'form-control';
        }
        
        switch ($validate) {
            case 'memo':
                $input = "<textarea class='$class' name='$name' id='$id' aria-describedby='" . $id . "Help' placeholder='Digite o $name_msg'></textarea>";
                break;
            default:
                $input = "<input type='$type' class='$class' name='$name' id='$id' aria-describedby='" . $id . "Help' placeholder='Digite o $name_msg'>";
        }
        
        $line .= $this->line($input, 8, 1);
        
        $line .= $this->line('</div>', 4, 1);
        
        return $line;
    }
}