<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/23
 * Time: 21:37
 */
class DatabaseManager
{
    //数据库pdo对象句柄
    private $db = null;
    //初始化
    function __construct()
    {
        $dbms='mysql';     //数据库类型
        $host='localhost'; //数据库主机名
        $dbName='wx_sise';    //使用的数据库
        $user='root';      //数据库连接用户名
        $pass='';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        try {
            $this->db = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
    //析构函数
    function __destruct()
    {
        // TODO: Implement __destruct() method.
//        $this->db = null;
        $this->close();
    }

    //增加
    function add($openid,$username,$password)
    {
        $statement = "INSERT INTO `users` ( `openid`, `username`, `password`) VALUES ( '".$openid."', '".$username."', '".$password."')";
//        $statement = "insert into users(openid,username,password) values('".$openid."','".$username."','".$password."')";
        return $this->db->exec($statement);
    }

    //删除
    function delete($openid)
    {
        $statement = "DELETE FROM `users` WHERE `users`.`openid` = '".$openid."';";
        return $this->db->exec($statement);
    }
    //查询
    function query($openid)
    {
        $statement = "SELECT * FROM `users` WHERE `openid` = '".$openid."'";
        $result = $this->db->query($statement);
        if ($result == false)
        {
            print_r($this->db->errorInfo());
            exit();
        }
        return $result;
    }

    //释放句柄
    function close()
    {
        $this->db = null;
    }


}