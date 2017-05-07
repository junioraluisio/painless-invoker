<?php
/**
 * Created by Factory.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 07/05/2017
 * Time: 13:05
*/

use Pandora\Validation\Validation;
use Entities\Auth\Users\Users;
use Entities\Auth\Users\UsersManager;


$validation = new Validation();

$check = [];

$table = 'auth_users';


$error = 0;

$msg = [];

foreach ($check as $item) {
    $error += ($item['response'] === false) ? 1 : 0;

    if (!empty($item['message'])) {
        $msg[] = $item['message'];
    }
}
if ($error < 1) {
    $users = new Users();


    $usersManager = new UsersManager($conn, $user);

    $op = $usersManager->insert();

    $msg = $op['message'];
    $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';
}

$ret = json_encode($msg);

echo $ret;