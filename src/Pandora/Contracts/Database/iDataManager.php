<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 31/05/2017
 * Time: 16:54
 */

namespace Pandora\Contracts\Database;


/**
 * Class DataManager
 * @package Pandora\Database
 */
interface iDataManager
{
    /**
     * @param string $fields
     *
     * @return array
     */
    public function all($fields = '*'): array;
    
    /**
     * @return array
     */
    public function disableById(): array;
    
    /**
     * @return array
     */
    public function enableById(): array;
    
    /**
     * @param array $fieldsValues
     * @param int   $limit
     *
     * @return array
     */
    public function findByFieldsValues(array $fieldsValues, int $limit): array;
    
    /**
     * @param array $fieldsValues
     *
     * @return bool
     */
    public function findUnique(array $fieldsValues): bool;
    
    /**
     * @param string $id
     *
     * @return array
     */
    public function findById($id): array;
    
    /**
     * @param array $fieldsValues
     *
     * @return array
     */
    public function insert(array $fieldsValues): array;
    
    /**
     * @return array
     */
    public function update(): array;
}