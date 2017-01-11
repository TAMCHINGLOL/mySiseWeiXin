<?php
/**
 * Created by PhpStorm.
 * User: TAM-CHING-LOL
 * Date: 2016/5/30
 * Time: 15:24
 * Event：个人信息
 */
require_once 'isBindLogin.php';
require_once 'sise/InfoMatchWebPage.php';
require_once 'OAuthGetOpenid.php';

    $code = $_REQUEST['code'];
    $getId = new GetOpenId();
    $userinfo = $getId->getUserInfo($code);
    $openid = $userinfo['openid'];
    $result = login(isBind($openid));

    if (is_object($result)){
        $infoMath = new InfoMatchWebPage();
        $infoMath->matchMsg($result->getLinks()['info'],$result->getCookie() );
        $resultes = $infoMath->getData();
    }else{
        echo "请先绑定账户！";
        exit;
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>个人信息</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user_scalable=no,initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="src/Js/jquery.mobile-1.3.2.css" />
    <script src="src/Js/jquery-1.10.2.js"></script>
    <script src="src/Js/jquery.mobile-1.3.2.js"></script>
</head>
<script type="text/javascript">
    function judgeType(val){
        switch (val){
            case '101':
                id0.style.display = "block";
                id1.style.display = "none";
                id2.style.display = "none";
                id3.style.display = "none";
                id4.style.display = "none";
                id5.style.display = "none";
                id6.style.display = "none";
                break;
            case '102':
                id1.style.display = "block";
                id0.style.display = "none";
                id2.style.display = "none";
                id3.style.display = "none";
                id4.style.display = "none";
                id5.style.display = "none";
                id6.style.display = "none";
                break;
            case '201':
                id2.style.display = "block";
                id0.style.display = "none";
                id1.style.display = "none";
                id3.style.display = "none";
                id4.style.display = "none";
                id5.style.display = "none";
                id6.style.display = "none";
                break;
            case '202':
                id3.style.display = "block";
                id0.style.display = "none";
                id2.style.display = "none";
                id1.style.display = "none";
                id4.style.display = "none";
                id5.style.display = "none";
                id6.style.display = "none";
                break;
            case '301':
                id4.style.display = "block";
                id0.style.display = "none";
                id2.style.display = "none";
                id3.style.display = "none";
                id1.style.display = "none";
                id5.style.display = "none";
                id6.style.display = "none";
                break;
            case '302':
                id5.style.display = "block";
                id0.style.display = "none";
                id2.style.display = "none";
                id3.style.display = "none";
                id4.style.display = "none";
                id1.style.display = "none";
                id6.style.display = "none";
                break;
            case '401':
                id6.style.display = "block";
                id0.style.display = "none";
                id2.style.display = "none";
                id3.style.display = "none";
                id4.style.display = "none";
                id5.style.display = "none";
                id1.style.display = "none";
                break;
        }
    }
</script>
<body style="font-size: 18px;">

<?php
    $term = array("2013年第一学期","2013年第二学期","2014年第一学期","2014年第二学期","2015年第一学期","2015年第二学期","2016年第一学期");

    for($j = 0; $j < count($term); $j++){
        $id = "id";
        $id.=$j;

        if($j == 0){
            echo '<table border="1" bordercolor="597AFE" style="display:block" id='.$id.'>';
        }else {
            echo '<table border="1" bordercolor="597AFE" style="display:none" id='.$id.'>';
        }
        echo"<tr> <th>课程代码</th><th>课程名称</th><th>考核方式</th><th>成绩</th><th>已得学分</th> </tr>";

        //按照学期分类课程
        for($i = 0; $i < count($resultes); $i++){
            if(iconv('GBK','UTF-8' ,$resultes[$i]['studiedterm'] ) == $term[$j]) {
?>
        <tr>
            <td><?php echo(iconv('GBK','UTF-8' ,$resultes[$i]['ccode'] ));?></td>
            <td><?php echo(iconv('GBK','UTF-8' ,$resultes[$i]['cname'] ));?></td>
            <td><?php echo(iconv('GBK','UTF-8' ,$resultes[$i]['type'] ));?></td>
            <td><?php echo(iconv('GBK','UTF-8' ,$resultes[$i]['score'] )); ?></td>
            <td><?php echo(($resultes[$i]['getcredit'] == "" ) ? "在读" : (iconv('GBK','UTF-8' ,$resultes[$i]['getcredit']))); ?></td>
        </tr>

<?php
            }
        }
        echo "</table>";
    }
?>

    <div data-theme="a" data-role="footer" data-position="fixed" >
       <form  method="get" action = "" style="font-size: 14px;">
        <select name="sel" onchange="judgeType(this.value)">
            <option value="101" >大一第1学期</option>
            <option value="102" >大一第2学期</option>
            <option value="201" >大二第1学期</option>
            <option value="202" >大二第2学期</option>
            <option value="301" >大三第1学期</option>
            <option value="302" >大三第2学期</option>
            <option value="401" >大四第1学期</option>
        </select>
        </form>
    </div>

</body>





