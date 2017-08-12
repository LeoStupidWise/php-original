<?php
/**
 * Created by PhpStorm.
 * User: YaZhou
 * Date: 2017/8/5
 * Time: 14:20
 */

require_once './helper.php';

$db_info    =  config('db');

$db_host    =  $db_info['host'];
$db_database=  $db_info['database'];

try {
    $db_conn    =  new PDO("mysql:host=$db_host;dbname=$db_database",
        $db_info['name'],
        $db_info['password']);

    $sql    =  "select * from test";
    $result =  $db_conn->query($sql);
    dump($db_conn);
    $result =  $result->fetchAll();
    dump($result);
} catch (\Exception $e) {
    dump($e->getTraceAsString());
}