<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/4/18
 * Time: 22:32
 */
include __DIR__.'/vendor/autoload.php';
include 'sise/simple_html_dom.php';
header("Content-Type:text/html;charset=utf-8");

//登录时要提交的数据
$post_data = "username=1340112222&password=lcc2789.&cbb38ac75f0f9406b2bab3b9ffb48488=29716dc47e2cec59eceb01e036e23ee9";
//登录验证url
$url = "http://class.sise.com.cn:7001/sise/login_check.jsp";
//$url = "http://class.sise.com.cn:7001/sise/login_check_login.jsp";
////cookie值保存位置
//$cookie_file = __DIR__ . '/cookie.txt';

//curl 初始化
$ch = curl_init();
//
curl_setopt($ch,CURLOPT_URL,$url);
//输出header部分"
curl_setopt($ch,CURLOPT_HEADER,1);
//返回输出流
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//获取cookie
//curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file);
//post提交方式
curl_setopt($ch,CURLOPT_POST,1);
//post提交的数据
curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
//执行curl
$content = curl_exec($ch);
//释放资源
curl_close($ch);


//匹配cookie值
preg_match('/Set-Cookie:(.*);/iU',$content,$str);
//将sessionID赋给$cookie变量
$cookie = $str[1];
//echo 'cookie:'.$cookie;

//$cookie = 'JSESSIONID=66xfXywTXQybypPzdmQhjJbf0L98lVkz4vkxDhCq179XGy0gVcTW!926358020';



//判断转向地址是否为成功登录的转向地址（即验证是否可以成功登录）
preg_match('/<script>(.*?)<\/script>/', $content, $match);
if(strpos($match[1], "/sise/index.jsp") != true){
    //登录失败
    //截取失败信息
//    echo substr($result, strpos($result, "messages=")+9, 10);
    echo 'login error';
    exit;
}


//爬取数据的url
$url2 = "http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
//$url2 = "http://class.sise.com.cn:7001/sise/module/commonresult/index.jsp";

$ch2 = curl_init();
curl_setopt($ch2,CURLOPT_URL,$url2);
curl_setopt($ch2,CURLOPT_RETURNTRANSFER,1);
//输出响应头
curl_setopt($ch2,CURLOPT_HEADER,1);

//设置登录验证时获取的cookie
curl_setopt($ch2,CURLOPT_COOKIE,$cookie);
//curl_setopt($ch2,CURLOPT_COOKIEFILE,$cookie_file);
$content2 = curl_exec($ch2);
curl_close($ch2);
////echo $content2;


//获取响应返回时间
preg_match('/Date:(?:.*GMT)/',$content2,$match1);
$matchResult = $match1[0];
//echo $matchResult;
preg_match_all('/[0-9]{1,}/',$matchResult,$ma);

//24小时制转12小时制的转换表
$changeNum = array('00'=>'00','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06',
    '07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12',
    '13'=>'01','14'=>'02','15'=>'03','16'=>'04','17'=>'05','18'=>'06',
    '19'=>'07','20'=>'08','21'=>'09','22'=>'10','23'=>'11','24'=>'00');

//url参数设置
$serialabc = '0'.$ma[0][4].$ma[0][0].$changeNum[$ma[0][2]].$ma[0][3].$ma[0][4];
//奖惩记录
$url3 = "http://class.sise.com.cn:7001/sise/module/encourage_punish/encourage_punish.jsp?stuname=刘昌创&gzcode=1340112222&serialabc=".$serialabc;
//个人信息
$url4 = 'http://class.sise.com.cn:7001/SISEWeb/pub/course/courseViewAction.do?method=doMain&studentid=RzIUoSdvyso=';
//课程表
$url5 = 'http://class.sise.com.cn:7001/sise/module/student_schedular/student_schedular.jsp';
//考勤信息
$url6 = 'http://class.sise.com.cn:7001/SISEWeb/pub/studentstatus/attendance/studentAttendanceViewAction.do?method=doMain&studentID=RzIUoSdvyso=&gzcode=T%2B1zxiw7vF/uyLXqmanKgQ==';
//考试时间
$url7 = 'http://class.sise.com.cn:7001/SISEWeb/pub/exam/studentexamAction.do?method=doMain&studentid=180443';
//晚归时间
$url8 = 'http://class.sise.com.cn:7001/SISEWeb/pub/studentstatus/lateStudentAction.do?method=doMain&gzCode=1340112222&md5Code=ebf5aaab612548d4b4b5ec5475952c53';
//echo $url3;
$ch3 = curl_init();
curl_setopt($ch3,CURLOPT_URL,$url3);
curl_setopt($ch3,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch3,CURLOPT_COOKIE,$cookie);
//curl_setopt($ch3,CURLOPT_COOKIEFILE,$cookie_file);
$content = curl_exec($ch3);
curl_close($ch3);
//echo $content;



/**
 * 匹配晚归违规
 */
/*$html = new simple_html_dom();
$html->load($content);
$table = $html->find('table',2);
//preg_replace('#\&nbsp\;#','....' ,$table );
preg_match_all('#<td[^>]*?>(.*?)</td>#',$table,$match );
//var_dump($match);
$tds = $match[1];
$tableArr = array();
$n = 0;
for ($i=0;$i<count($tds);$i=$i+2)
{
    $tableArr[$n]['times']=$tds[$i];
    $tableArr[$n]['remarks']=$tds[$i+1];
    $n++;
}
$html->clear();
var_dump($tableArr);*/







/**
 * 匹配考试时间
 */
/*
$html = new simple_html_dom();
$html->load($content);
$table = $html->find('table',4);
preg_match_all('#<td[^>]*?>(.*?)</td>#',$table,$match);
$tds = $match[1];
$tableArr = array();
$n = 0;
for ($i=0;$i<count($tds);$i=$i+8)
{
    $tableArr[$n]['code']=$tds[$i];
    $tableArr[$n]['cname']=$tds[$i+1];
    $tableArr[$n]['date']=$tds[$i+2];
    $tableArr[$n]['time']=$tds[$i+3];
    $tableArr[$n]['examcode']=$tds[$i+4];
    $tableArr[$n]['examroom']=$tds[$i+5];
    $tableArr[$n]['seat']=$tds[$i+6];
    $tableArr[$n]['status']=$tds[$i+7];
    $n++;
}
$html->clear();
var_dump($tableArr);*/



/**
 * 匹配奖惩记录
 * charset = utf-8
 */

$html = new simple_html_dom();
$html->load($content);
$good = $html->find('table',3);
$bad = $html->find('table',4);

/*//奖励记录
$html->load("$good");
$tds = $html->find('tr td');
$table_arr = array();
$n = 0;
foreach ($tds as $td)
{
    $table_arr['good'][$n] = strip_tags($td);
    $n++;
}
var_dump($table_arr);*/

$html->load("$bad");
$tds = $html->find('tr td');
$table_arr1 = array();
$n = 0;
foreach ($tds as $td)
{
    $table_arr1['bad'][$n] = strip_tags($td);
    $n++;
}
var_dump($table_arr1);

/*
$tds = preg_replace("#<strong[^>]*?>(.*?)</strong[^>]*?>#","$1",$tds);
var_dump($tds);
$table_arr = array();
//echo count($tds);
$n =0;
for($i =1;$i<count($tds);$i=$i+6)
{
    if(isset($tds[7]))
    {
        $table_arr[$n]['year']=$tds[$i];
        $table_arr[$n]['form']=$tds[$i+1];
        $table_arr[$n]['level']=$tds[$i+2];
        $table_arr[$n]['reasion']=$tds[$i+3];
        $table_arr[$n]['dep']=$tds[$i+4];
        $table_arr[$n]['date']=$tds[$i+5];
        $n++;
    }else
    {
        $table_arr['message']='暂无数据';
    }
}
var_dump($table_arr);

//惩罚记录
$html->load("$bad");
$tds1 = $html->find('tr td');
$tds1 = preg_replace("#<strong[^>]*?>(.*?)</strong[^>]*?>#","$1",$tds1);
var_dump($tds1);

$table_arr1 = array();

//echo count($tds);
$n =0;
for($i =1;$i<count($tds1);$i=$i+8)
{
    if(isset($tds1[9]))
    {
        $table_arr[$n]['year']=$tds1[$i];
        $table_arr[$n]['form']=$tds1[$i+1];
        $table_arr[$n]['level']=$tds1[$i+2];
        $table_arr[$n]['reasion']=$tds1[$i+3];
        $table_arr[$n]['dep']=$tds1[$i+4];
        $table_arr[$n]['date']=$tds1[$i+5];
        $n++;
    }else
    {
        $table_arr1['message']='暂无数据';
    }
}
var_dump($table_arr1);
$html->clear();*/










/**
 * 匹配考勤信息
 */

/*$html = new simple_html_dom();
$html->load($content);
$trs = $html->find('tr.odd,tr.even');
$resArr = array();
$i = 0;
foreach ($trs as $tr)
{
    preg_match_all('#<td[^>]*?>(.*?)</td>#', $tr, $match);
    $resArr[$i]['code'] = $match[1][0];
    $resArr[$i]['cname'] = $match[1][1];
    $resArr[$i]['status'] = $match[1][2];
    $i++;
}
var_dump($resArr);
$html->clear();*/





/**
 * 匹配个人信息页面中的课程信息
 */

/*$html = new simple_html_dom();
$html->load($content);
$trs = $html->find('tr.odd,tr.even');
$i = 0;
$term = null;
$resArr = array();
foreach ($trs as $tr)
{
    //echo $tr;
//    $a = strip_tags($tr);
//    $s = explode(' ',$tr);
//    print_r();
//      echo $tr;
    $tr = preg_replace('#<a[^>]*>(.*?)</a>#',"$1",$tr);
//      echo $tr;
    preg_match_all('#<td[^>]*>(.*?)</td>#',$tr,$match);
//      print_r($match);
    $arr = $match[1];
//      var_dump($arr);
    $length = count($arr);
    if ($length == 10)
    {
        if ($arr[0] != ''){
            $term =$arr[0];
        }
        $resArr[($i)]['term']="$term";
        $resArr[($i)]['ccode']="$arr[1]";
        $resArr[($i)]['cname']="$arr[2]";
        $resArr[($i)]['credit']="$arr[3]";
        $resArr[($i)]['type']="$arr[4]";
        $resArr[($i)]['pre']="$arr[5]";
        $resArr[($i)]['same']="$arr[6]";
        $resArr[($i)]['studiedterm']="$arr[7]";
        $resArr[($i)]['score']="$arr[8]";
        $resArr[($i)]['getcredit']="$arr[9]";
    }else{
//             $resArr[($i)]['term']="$term";
        $resArr[($i)]['ccode']="$arr[0]";
        $resArr[($i)]['cname']="$arr[1]";
        $resArr[($i)]['credit']="$arr[2]";
        $resArr[($i)]['type']="$arr[3]";
        $resArr[($i)]['pre']="$arr[4]";
        $resArr[($i)]['same']="$arr[5]";
        $resArr[($i)]['studiedterm']="$arr[6]";
        $resArr[($i)]['score']="$arr[7]";
        $resArr[($i)]['getcredit']="$arr[8]";
    }
    $i++;
}
var_dump($resArr);
$html->clear();*/


/**
 * 匹配课程表
 */
/*$html = new simple_html_dom();
$html->load($content);
$table = $html->find('table',-1);
//echo $table;
$table = preg_replace("#</td><tr[^>]*?>#",'</td></tr><tr>',$table);
//echo $table;
$html->load($table);
$tds = $html->find('tr td');
$tds = preg_replace("#<strong[^>]*?>(.*?)</strong[^>]*?>#","$1",$tds);
//var_dump($tds);
$table_arr = array();
$n = 0;
for ($i = 0;$i<9;$i++)
{
    for ($j = 0;$j<8;$j++)
    {
        $table_arr[$i][$j] = strip_tags($tds[$n++]);
    }
}
var_dump($table_arr);
$html->clear();*/
