<?php
/**
 * Created by Factory.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 07/05/2017
 * Time: 13:05
*/

use Entities\Auth\Users\Users;
use Entities\Auth\Users\UsersManager;

$id = isset($_REQUEST['ipt_id']) ? $_REQUEST['ipt_id'] : '';

$users = new Users();

$users->setId($id);

$usersManager = new UsersManager($conn, $users);

$op = $usersManager->disableById();

$msg  = $op['message'];
$msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';

$ret = json_encode($msg);

echo $ret;

