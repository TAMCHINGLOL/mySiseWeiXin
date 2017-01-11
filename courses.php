<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/27
 * Time: 23:30
 */
require_once 'isBindLogin.php';
require_once 'sise/InfoMatchWebPage.php';
require_once 'sise/CourseMathWebPage.php';
require_once 'OAuthGetOpenid.php';

$code = $_REQUEST['code'];
$getId = new GetOpenId();
$userinfo = $getId->getUserInfo($code);
$openid = $userinfo['openid'];
$result = login(isBind($openid));
if (is_object($result)){
    $course = new CourseMathWebPage();
    $course->matchMsg($result->getLinks()['classview'],$result->getCookie() );
    $result = $course->getData();
}else{
    echo "请先绑定账户！";
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>开设课程</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,user_scalable=no,initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="src/Js/jquery.mobile-1.3.2.css" />
    <script src="src/Js/jquery-1.10.2.js"></script>
    <script src="src/Js/jquery.mobile-1.3.2.js"></script>
</head>
<script type="text/javascript">
    function judgeType(val){
        switch (val) {
            case '101':
                id0.style.display = "block";
                id1.style.display = "none";
                id2.style.display = "none";
                break;
            case '102':
                id1.style.display = "block";
                id0.style.display = "none";
                id2.style.display = "none";
                break;
        }
    }
</script>
<body style="font-size: 18px;">

<?php
$term = array("必修","艺术");
$cl = array("bi","yi");
for($j = 0; $j < count($term); $j++) {
    $id = "id";
    $id .= $j;
    $bi = $cl[$j];
    if ($j == 0) {
        echo '<table border="3" bordercolor="597AFE" cellspacing="0px" style="display:block" id=' . $id . '>';
    } else {
        echo '<table border="3" bordercolor="597AFE" cellspacing="0px" style="display:none" id=' . $id . '>';
    }

    echo "<tr> <th>课程代码</th><th>课程名称</th><th>学分</th><th>考核方式</th><th>先修课程</th></tr>";

    for ($i = 1; $i < count($result[$bi]); $i++) {
        if ($result[$bi][$i]['type'] == $term[$j]) {
            ?>
            <tr>
                <td><?php echo(iconv('GBK', 'UTF-8', $result[$bi][$i]['code'])); ?></td>
                <td><?php echo(iconv('GBK','UTF-8',$result[$bi][$i]['cname'])); ?></td>
                <td><?php echo(iconv('GBK', 'UTF-8', $result[$bi][$i]['credit'])); ?></td>
                <td><?php echo (iconv('GBK','UTF-8',$result[$bi][$i]['way'])); ?></td>
                <td><?php echo (iconv('GBK','UTF-8',$result[$bi][$i]['pre'])); ?></td>
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
            <option value="101" >必修课程</option>
            <option value="102" >艺术限选</option>
        </select>
    </form>
</div>

</body>