<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 08/08/2017
 * Time: 07:57
 */

namespace Pandora\Contracts\Validation;

use Pandora\Connection\Conn;

interface iValidation
{
    /**
     * @param mixed $bool
     *
     * @return array
     */
    public function isBool($bool): array;
    
    /**
     * @param $cnpj
     *
     * @return array
     */
    public function isCnpj($cnpj): array;
    
    /**
     * @param string $cpf
     *
     * @return array
     */
    public function isCpf($cpf): array;
    
    /**
     * @param string $email
     *
     * @return array
     */
    public function isEmail(string $email): array;
    
    /**
     * @param mixed $float
     *
     * @return array
     */
    public function isFloat($float): array;
    
    /**
     * @param mixed $int
     *
     * @return array
     */
    public function isInt($int): array;
    
    /**
     * @param string $ip
     *
     * @return array
     */
    public function isIp(string $ip): array;
    
    /**
     * @param $login
     *
     * @return array
     */
    public function isLogin($login): array;
    
    /**
     * @param string $mac
     *
     * @return array
     */
    public function isMac(string $mac): array;
    
    /**
     * @param $str
     * @param $field
     *
     * @return array
     */
    public function isNotEmpty($str, $field);
    
    /**
     * @param string $password
     *
     * @return array
     */
    public function isPassword(string $password): array;
    
    /**
     * @param \Pandora\Connection\Conn $conn
     * @param string                   $table
     * @param string                   $field
     * @param string                   $value
     * @param string                   $id
     *
     * @return array
     */
    public function isUnique(Conn $conn, string $table, string $field, string $value, string $id): array;
    
    /**
     * @param string $url
     *
     * @return array
     */
    public function isUrl(string $url);
}