<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 25/05/2017
 * Time: 07:09
 */

namespace Pandora\Contracts\Utils;

/**
 * Interface iExtractFiles
 * @package Pandora\Contracts
 */
interface iExtractFiles
{
    /**
     * iExtractFiles constructor.
     *
     * @param string $path
     */
    public function __construct(string $path);
    
    /**
     * @return array
     */
    public function files(): array;
}