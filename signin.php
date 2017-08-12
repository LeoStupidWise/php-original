<?php
/**
 * Created by PhpStorm.
 * User: YaZhou
 * Date: 2017/8/6
 * Time: 8:52
 */

require_once './helper.php';

$nickname    =  $_POST['nickname'];
$user_name   =  $_POST['username'];
$password    =  $_POST['password'];
$password_confirm    =  $_POST['password_confirm'];

if (!$user_name || !$password) {
    jsAlert('Please confirm you message');
    return jsToBackPage();
}

if ($password !== $password_confirm) {
    return jsAlertAndToBackPage('Please confirm you password');
}

$pdo_connection    =  pdoDefaultConnect();

try {
    $table      =  'user';
    date_default_timezone_set('UTC');
    $time       =  date('Y-m-d H:i:s', time());
    /*
     * 在一个PHP进程中，如果没有设置时区，PHP会去读系统的时区，同时会抛出一个警告“It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function.”。所以时区设置最好在入口文件就进行设定，但这里没有入口文件，那就在这设定了。
     */
    $pdo_pre    =  $pdo_connection->prepare("SELECT * FROM user WHERE name = ?");
//    $pdo_pre->bindParam(1, $user_name, PDO::PARAM_STR);
    $result      =  $pdo_pre->execute([
        $user_name
    ]);
    /**
     * prepare 不能对表名就行预处理，比如 PDO::prepare("select * from ? where name = ?)
     * 是因为高贵的 prepare 会做转义处理，并加上引号
     *
     * 绑定参数可以用 bindParam，也可以在 execute 里面直接传，倾向后者。
     *
     * 获取 PDO 的错误是在 PDOStatement 中获取，不是 execute 后的结果中。另外，PDOStatement 的相关变量经常以 stmt 出现，我这里一般是 pdo_pre，可以改成 pdo_stmt
     */
    $result     =  $pdo_pre->fetchAll();
    if (count($result) > 0) {
        return jsAlertAndToBackPage('Sorry, the name have been signed');
    }
    $password   =  md5($password);
    $sql        =  "INSERT INTO $table (name, nickname, password, created_at) VALUES (?, ?, ?, ?)";
    $pdo_pre    =  $pdo_connection->prepare($sql);
    $result     =  $pdo_pre->execute([
        $user_name,
        $nickname,
        $password,
        $time
    ]);
    // 针对 insert 语句，execute 返回的是一个布尔值
    if (!$result) {
        return jsAlertAndToBackPage('Sorry, please try it again');
    }

} catch (\Exception $e) {
    echo $e->getTraceAsString();
}