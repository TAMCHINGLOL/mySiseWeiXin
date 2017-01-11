<?php
/**
 * Created by PhpStorm.
 * User: TAM_CHING_LOL
 * Date: 2016/5/30
 * Time: 19:17
 */
require_once 'sise/MatchControler.php';
require_once 'sise/DatabaseManager.php';
//绑定校验
function isBind($openid)
{
    $dbm = new DatabaseManager();
    $result = $dbm->query($openid);
    if ($result->rowCount())
        return $result;

    return false;
}

//登陆
function login($data)
{
    if (is_object($data) || $data)
    {
        $control = new MatchControler();
        $row = $data->fetch();
        $control->checkLoginAndGetCookie($row['username'], $row['password']);
        $control->getMainPageLinks();
        return $control;
    }else{
        echo "请输入账号";
        exit();
    }
    return $data;
}