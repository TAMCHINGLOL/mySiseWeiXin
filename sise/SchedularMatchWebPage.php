<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/8
 * Time: 9:13
 * Event：课程表
 */
use EasyWeChat\Message\Text;
require_once 'AbstractMatchWebPage.php';
require_once 'simple_html_dom.php';
class SchedularMatchWebPage extends  AbstractMatchWebPage
{
    //匹配到的数据
//    private $data;

    function matchMsg($url,$cookie)
    {
//        $url = 'http://class.sise.com.cn:7001/sise/module/student_schedular/student_schedular.jsp';
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $table = $html->find('table',-1);
//echo $table;
        $table = preg_replace("#</td><tr[^>]*?>#",'</td></tr><tr>',$table);
//echo $table;
        $html->load($table);
        $tds = $html->find('tr td');
        $tds = preg_replace("#<strong[^>]*?>(.*?)</strong[^>]*?>#","$1",$tds);
//var_dump($tds);
//        $this->data = array();
        $n = 0;
        for ($i = 0;$i<9;$i++)
        {
            for ($j = 0;$j<8;$j++)
            {
                $old = strip_tags($tds[$n++]);
                $new = preg_replace('#\&nbsp\;#','' ,$old );
                $this->data[$i][$j] = $new;
            }
        }
        $html->clear();
//        var_dump($this->data);
    }


    function rebuildMsg()
    {
       
    }

//    function monday()
//    {
//        $text = new Text();
//        for ($i = 0;$i<count($this->data);$i++)
//        {
//            if ($this->data[$i][1] == '')
//            {
//                continue;
//            }
//            $text->content .= iconv('GBK','UTF-8' ,$this->data[$i][0] )."\n".iconv('GBK','UTF-8' ,$this->data[$i][1] )."\n";
//        }
//        return $text;
//    }

    function week($day)
    {
        $text = new Text();
        for ($i = 0;$i<count($this->data);$i++)
        {
            if ($this->data[$i][$day] == '')
            {
                continue;
            }
            $text->content .= iconv('GBK','UTF-8' ,$this->data[$i][0] )."\n".
                iconv('GBK','UTF-8' ,$this->data[$i][$day] )."\n\n";
        }
        return $text;
    }

}