<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 10/06/2018
 * Time: 16:07
 */

namespace Pandora\Http;


class Requisitions
{
    /**
     * @var
     */
    private $ch;
    /**
     * @var array
     */
    private $fields;
    /**
     * @var string [GET, POST]
     */
    private $type;
    /**
     * @var string com a url que será consumida
     */
    private $url;
    
    /**
     * Requisitions constructor.
     *
     * @param string $url
     * @param string $type
     * @param array  $fields
     */
    public function __construct()
    {
        $this->ch = curl_init();
    }
    
    /**
     * @param string $url
     * @param string $type
     * @param array  $fields
     *
     * @return mixed
     */
    public function exec(string $url, string $type, array $fields)
    {
        $this->setUrl($url);
        $this->setType($type);
        $this->setFields($fields);
        
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        
        $exec = curl_exec($this->ch);
        
        return $exec;
    }
    
    /**
     * @param string $type
     *
     * @return Requisitions
     */
    public function setType(string $type): Requisitions
    {
        switch ($type) {
            case 'post':
                $this->type = CURLOPT_POST;
                break;
            default:
                $this->type = CURLOPT_HTTPGET;
        }
        
        curl_setopt($this->ch, $this->type, true);
        
        return $this;
    }
    
    public function __destruct()
    {
        curl_close($this->ch);
    }
    
    /**
     * @param array $fields
     *
     * @return Requisitions
     */
    public function setFields(array $fields): Requisitions
    {
        $this->fields = $fields;
        
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields);
        
        return $this;
    }
    
    /**
     * @param string $url
     *
     * @return Requisitions
     */
    public function setUrl(string $url): Requisitions
    {
        $this->url = $url;
        
        curl_setopt($this->ch, CURLOPT_URL, $url);
        
        return $this;
    }
}