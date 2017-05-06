<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/03/2017
 * Time: 11:19
 */

namespace Pandora\Validation;


use Pandora\Connection\Conn;

class Validation
{
    /**
     * @param mixed $bool
     *
     * @return array
     */
    public function isBool($bool)
    {
        if (filter_var($bool, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) {
            $ret = [
                'response' => false,
                'message'  => '"' . $bool . '" não é um valor booleano válido!'
            ];
        } else {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param $cnpj
     *
     * @return array
     */
    public function isCnpj($cnpj)
    {
        // Verifica se um número foi informado
        if (empty($cnpj)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para o CNPJ!'
            ];
            
            return $ret;
        }
        
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        
        // Valida tamanho
        if (strlen($cnpj) != 14) {
            $ret = [
                'response' => false,
                'message'  => 'O número de caracteres digitados não pode ser diferente de 14!'
            ];
            
            return $ret;
        }
        
        // Lista de CNPJs inválidos
        $invalids = [
            '00000000000000',
            '11111111111111',
            '22222222222222',
            '33333333333333',
            '44444444444444',
            '55555555555555',
            '66666666666666',
            '77777777777777',
            '88888888888888',
            '99999999999999'
        ];
        
        // Verifica se o CPF está na lista de inválidos
        if (in_array($cnpj, $invalids)) {
            $ret = [
                'response' => false,
                'message'  => 'A sequência "' . $cnpj . '" não é um CNPJ válido!'
            ];
            
            return $ret;
        }
        
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj{$i} * $j;
            $j   = ($j == 2) ? 9 : $j - 1;
        }
        
        $rest = $sum % 11;
        
        if ($cnpj{12} != ($rest < 2 ? 0 : 11 - $rest)) {
            $ret = [
                'response' => false,
                'message'  => '"' . $cnpj . '" não é um CNPJ válido!'
            ];
            
            return $ret;
        }
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj{$i} * $j;
            $j   = ($j == 2) ? 9 : $j - 1;
        }
        
        $rest = $sum % 11;
        
        $verify = $cnpj{13} == ($rest < 2 ? 0 : 11 - $rest);
        
        if (!$verify) {
            $ret = [
                'response' => false,
                'message'  => '"' . $cnpj . '" não é um CNPJ válido!'
            ];
            
            return $ret;
        } else {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
            
            return $ret;
        }
    }
    
    /**
     * @param string $cpf
     *
     * @return array
     */
    public function isCpf($cpf)
    {
        // Verifica se um número foi informado
        if (empty($cpf)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para o CPF!'
            ];
            
            return $ret;
        }
        
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        // Valida tamanho
        if (strlen($cpf) != 11) {
            $ret = [
                'response' => false,
                'message'  => 'O número de caracteres digitados não pode ser diferente de 11 (onze)!'
            ];
            
            return $ret;
        }
        
        // Lista de CPFs inválidos
        $invalids = [
            '00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999'
        ];
        
        // Verifica se o CPF está na lista de inválidos
        if (in_array($cpf, $invalids)) {
            $ret = [
                'response' => false,
                'message'  => 'A sequência "' . $cpf . '" não é um CPF válido!'
            ];
            
            return $ret;
        }
        
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--) {
            $sum += $cpf{$i} * $j;
        }
        
        $rest = $sum % 11;
        
        if ($cpf{9} != ($rest < 2 ? 0 : 11 - $rest)) {
            $ret = [
                'response' => false,
                'message'  => $cpf . ' não é um CPF válido!'
            ];
            
            return $ret;
        }
        
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--) {
            $sum += $cpf{$i} * $j;
        }
        
        $rest = $sum % 11;
        
        $validation = ($cpf{10} == ($rest < 2 ? 0 : 11 - $rest));
        
        if (!$validation) {
            $ret = [
                'response' => false,
                'message'  => '"' . $cpf . '" não é um CPF válido!'
            ];
        } else {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param string $email
     *
     * @return array
     */
    public function isEmail(string $email)
    {
        // Verifica se um valor foi informado
        if (empty($email)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para o email!'
            ];
            
            return $ret;
        }
        
        $ret = [
            'response' => false,
            'message'  => '"' . $email . '" não é um email válido!'
        ];
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param mixed $float
     *
     * @return array
     */
    public function isFloat($float)
    {
        $ret = [
            'response' => false,
            'message'  => '"' . $float . '" não é valor float válido!'
        ];
        
        if (filter_var($float, FILTER_VALIDATE_FLOAT)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param mixed $int
     *
     * @return array
     */
    public function isInt($int)
    {
        $ret = [
            'response' => false,
            'message'  => '"' . $int . '" não é valor integer válido!'
        ];
        
        if (filter_var($int, FILTER_VALIDATE_INT)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param string $ip
     *
     * @return array
     */
    public function isIp(string $ip)
    {
        // Verifica se um valor foi informado
        if (empty($ip)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para o IP!'
            ];
            
            return $ret;
        }
        
        $ret = [
            'response' => false,
            'message'  => '"' . $ip . '" não é um IP válido!'
        ];
        
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param $login
     *
     * @return array
     */
    public function isLogin($login)
    {
        if (empty($login)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para o login!'
            ];
            
            return $ret;
        }
        
        if (strlen($login) < 6) {
            $ret = [
                'response' => false,
                'message'  => 'O login deve ter no mínimo 06 (seis) caracteres!'
            ];
            
            return $ret;
        }
        
        $ret = [
            'response' => true,
            'message'  => ''
        ];
        
        return $ret;
    }
    
    /**
     * @param string $mac
     *
     * @return array
     */
    public function isMac(string $mac)
    {
        // Verifica se um valor foi informado
        if (empty($mac)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para o mac!'
            ];
            
            return $ret;
        }
        
        $ret = [
            'response' => false,
            'message'  => '"' . $mac . '" não é um MAC válido!'
        ];
        
        if (filter_var($mac, FILTER_VALIDATE_MAC)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param $str
     * @param $field
     *
     * @return array
     */
    public function isNotEmpty($str, $field)
    {
        if (!empty($str)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        } else {
            $ret = [
                'response' => false,
                'message'  => 'Preencha um valor para o campo "' . $field . '"!'
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param string $password
     *
     * @return array
     */
    public function isPassword(string $password)
    {
        // Verifica se um valor foi informado
        if (empty($password)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para a senha!'
            ];
            
            return $ret;
        }
        
        $strLenPsw = strlen($password);
        
        $j = $strLenPsw - 1;
        
        for ($i = 0; $i < $j; $i++) {
            $digitCurrent = $password{$i};
            $digitPrev    = $i > 0 ? $password{$i + 1} : '';
            
            if ($digitCurrent == $digitPrev) {
                $ret = [
                    'response' => false,
                    'message'  => 'A senha não pode conter caracteres seguidos iguais!'
                ];
                
                return $ret;
            }
        }
        
        // Verifica o tamanho da senha
        if ($strLenPsw < 8) {
            $ret = [
                'response' => false,
                'message'  => 'A senha deve ter no mínimo 8 (oito) dígitos!'
            ];
            
            return $ret;
        }
        
        // Verifica se tem pelo menos 1 letra maiúscula
        preg_match("/[A-Za-z]/", $password, $arrLetter);
        if (count($arrLetter) === 0) {
            $ret = [
                'response' => false,
                'message'  => 'A senha deve ter pelo menos 1 (uma) letra!'
            ];
            
            return $ret;
        }
        
        // Verifica se tem pelo menos 1 letra maiúscula
        preg_match("/[A-Z]/", $password, $arrUpperLetter);
        if (count($arrUpperLetter) === 0) {
            $ret = [
                'response' => false,
                'message'  => 'A senha deve ter pelo menos 1 (uma) letra maiúscula!'
            ];
            
            return $ret;
        }
        
        // Verifica se tem pelo menos 1 número
        preg_match("/[0-9]/", $password, $arrNumber);
        if (count($arrNumber) === 0) {
            $ret = [
                'response' => false,
                'message'  => 'A senha deve ter pelo menos 1 (um) número!'
            ];
            
            return $ret;
        }
        
        $ret = [
            'response' => true,
            'message'  => ''
        ];
        
        return $ret;
    }
    
    /**
     * @param \Entities\Connection\Conn $conn
     * @param string                    $table
     * @param string                    $field
     * @param string                    $value
     *
     * @return array
     */
    public function isUnique(Conn $conn, string $table, string $field, string $value)
    {
        $sql = 'SELECT ' . $field;
        $sql .= ' FROM ' . $table;
        $sql .= ' WHERE ' . $field . ' = "' . $value . '"';
        $sql .= ' LIMIT 1';
        
        $result = $conn->prepare($sql);
        
        $result->execute();
        
        $numRows = $result->rowCount();
        
        $ret = [
            'response' => true,
            'message'  => ''
        ];
        
        if ($numRows > 0) {
            $ret = [
                'response' => false,
                'message'  => 'O valor "' . $value . '" já existe no banco de dados e não pode ser duplicado!'
            ];
        }
        
        return $ret;
    }
    
    /**
     * @param string $url
     *
     * @return array
     */
    public function isUrl(string $url)
    {
        // Verifica se um valor foi informado
        if (empty($url)) {
            $ret = [
                'response' => false,
                'message'  => 'Digite um valor para a URL!'
            ];
            
            return $ret;
        }
        
        $ret = [
            'response' => false,
            'message'  => '"' . $url . '" não é uma URL válida!'
        ];
        
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $ret = [
                'response' => true,
                'message'  => ''
            ];
        }
        
        return $ret;
    }
}