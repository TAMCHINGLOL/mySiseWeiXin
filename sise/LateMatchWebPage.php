<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/22
 * Time: 20:54
 * 违规晚归
 */
//include 'simple_html_dom.php';
use EasyWeChat\Message\Text;
class LateMatchWebPage extends AbstractMatchWebPage
{
    function matchMsg($url, $cookie)
    {
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $table = $html->find('table',2);
//preg_replace('#\&nbsp\;#','....' ,$table );
        preg_match_all('#<td[^>]*?>(.*?)</td>#',$table,$match );
//var_dump($match);
        $tds = $match[1];
//        $tableArr = array();
        $n = 0;
        for ($i=0;$i<count($tds);$i=$i+2)
        {
            $this->data[$n]['times']=preg_replace('#\&nbsp\;#','',$tds[$i]);
            $this->data[$n]['remarks']=preg_replace('#\&nbsp\;#','',$tds[$i+1]);
            $n++;
        }
        $html->clear();
//        var_dump($this->data);
    }
    function rebuildMsg()
    {
        $text = new Text();
        $text->content = "晚归违规记录：\n";
        for ($i = 0;$i<count($this->data);$i++)
        {
            $text->content .=  iconv('GBK','UTF-8' ,$this->data[$i]['times'] )."\n".
                iconv('GBK','UTF-8' ,$this->data[$i]['remarks'] )."\n\n";
        }
        return $text;
    }
}