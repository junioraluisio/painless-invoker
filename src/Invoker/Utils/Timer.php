<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/04/2017
 * Time: 15:14
 */

namespace Invoker\Utils;


class Timer
{
    private $timeStart;
    private $timeEnd;
    
    
    /**
     * @return string
     */
    public function elapsed()
    {
        return number_format($this->getTimeEnd() - $this->getTimeStart(), 2, ',', ''); // em segundos
    }
    
    public function show(){
        $msg = 'Time spent:  ' . $this->elapsed() . ' seconds.';
        
        return $msg;
    }
    
    /**
     * @return mixed
     */
    private function getTimeStart()
    {
        return $this->timeStart;
    }
    
    /**
     *
     */
    public function setTimeStart()
    {
        $this->timeStart = microtime(true);
    }
    
    /**
     * @return mixed
     */
    private function getTimeEnd()
    {
        return $this->timeEnd;
    }
    
    /**
     *
     */
    public function setTimeEnd()
    {
        $this->timeEnd = microtime(true);
    }
    
    
}