<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 14/04/2018
 * Time: 16:55
 */

namespace Pandora\TwigExtensions;


use Twig\TwigFilter;

class Increase extends \Twig_Extension
{
    /**
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('date', [$this, 'dateFormat'])
        ];
    }
    
    /**
     * @param        $date
     * @param string $format
     *
     * @return false|string
     */
    public function dateFormat($date, $format = 'd/m/Y')
    {
        $date = date_create($date);
        
        return date_format($date, $format);
    }
    
}