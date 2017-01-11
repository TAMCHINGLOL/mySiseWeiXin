<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/4/25
 * Time: 9:39
 * 个人信息
 */
require_once 'simple_html_dom.php';
require_once 'AbstractMatchWebPage.php';
use EasyWeChat\Message\Text;
class InfoMatchWebPage extends AbstractMatchWebPage
{
    //匹配到的数据
//    private $data;

    function matchMsg($url,$cookie)
    {
       // $url = 'http://class.sise.com.cn:7001/SISEWeb/pub/course/courseViewAction.do?method=doMain&studentid=RzIUoSdvyso=';
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $trs = $html->find('tr.odd,tr.even');
        //print_r($trs);
        $i = 0;
        $term = null;
        foreach ($trs as $tr)
        {
            //echo $tr;
//    $a = strip_tags($tr);
//    $s = explode(' ',$tr);
//    print_r();
//      echo $tr;
            //搜索$tr中匹配的#<a[^>]*>(.*?)</a>#,以$1进行替换
            $tr = preg_replace('#<a[^>]*>(.*?)</a>#',"$1",$tr);
     // echo $tr;
            preg_match_all('#<td[^>]*>(.*?)</td>#',$tr,$match);
//          print_r($match);
            $arr = $match[1];
          //  var_dump($arr);
            $length = count($arr);
            if ($length == 10)
            {
                if ($arr[0] != ''){
                    $term =$arr[0];
                }
                $this->data[($i)]['term']="$term";
                $this->data[($i)]['ccode']="$arr[1]";
                $this->data[($i)]['cname']="$arr[2]";
                $this->data[($i)]['credit']="$arr[3]";
                $this->data[($i)]['type']="$arr[4]";
                $this->data[($i)]['pre']="$arr[5]";
                $this->data[($i)]['same']="$arr[6]";
                $this->data[($i)]['studiedterm']="$arr[7]";
                $this->data[($i)]['score']="$arr[8]";
                $this->data[($i)]['getcredit']="$arr[9]";
            }else{
//            $this->data[($i)]['term']="$term";
                $this->data[($i)]['ccode']="$arr[0]";
                $this->data[($i)]['cname']="$arr[1]";
                $this->data[($i)]['credit']="$arr[2]";
                $this->data[($i)]['type']="$arr[3]";
                $this->data[($i)]['pre']="$arr[4]";
                $this->data[($i)]['same']="$arr[5]";
                $this->data[($i)]['studiedterm']="$arr[6]";
                $this->data[($i)]['score']="$arr[7]";
                $this->data[($i)]['getcredit']="$arr[8]";
            }
            $i++;
        }
         //var_dump($this->data);
    }

    function rebuildMsg()
    {

    }
}