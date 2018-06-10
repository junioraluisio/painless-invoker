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
     * @var string com a url que será consumida
     */
    private $url;
    
    /**
     * @var
     */
    private $ch;
    
    /**
     * @var string [GET, POST]
     */
    private $type;
    
    /**
     * Requisitions constructor.
     *
     * @param string $url
     * @param string $type
     * @param array  $fields
     */
    public function __construct(string $url, string $type, array $fields)
    {
        $this->type = $type;
        
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($this->ch, $this->setType($type), true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($this->ch);
        
        return $result;
    }
    
    /**
     * @param string $type
     *
     * @return int
     */
    private function setType(string $type)
    {
        switch ($type) {
            case 'post':
                $ret = CURLOPT_POST;
                break;
            default:
                $ret = CURLOPT_HTTPGET;
        }
        
        return $ret;
    }
    
    public function __destruct()
    {
        curl_close($this->ch);
    }
}