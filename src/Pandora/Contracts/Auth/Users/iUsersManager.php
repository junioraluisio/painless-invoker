<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 30/05/2017
 * Time: 10:05
*/

namespace Pandora\Contracts\Auth\Users;


interface iUsersManager
{
    /**
     * @param string $fields
     *
     * @return array
     */
    public function all($fields = '*'): array;

    /**
     * @param string $id
     *
     * @return array
     */
    public function findById($id): array;

    /**
      * @param array $fieldsValues
      * @param int   $limit
      *
      * @return array
      */
    public function findByFieldsValues(array $fieldsValues, int $limit): array;

    /**
     * @return array
     */
    public function insert(): array;

    /**
     * @return array
     */
    public function update(): array;

    /**
     * @return array
     */
    public function disableById(): array;

    /**
     * @return array
     */
    public function enableById(): array;
}