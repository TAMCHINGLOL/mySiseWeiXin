<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/22
 * Time: 19:58
 * Event:考勤信息
 */
use EasyWeChat\Message\Text;

class AttendMatchWebPage extends AbstractMatchWebPage
{
    function matchMsg($url, $cookie)
    {
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $trs = $html->find('tr.odd,tr.even');
//        $this->data = array();
        $i = 0;
        foreach ($trs as $tr)
        {
            preg_match_all('#<td[^>]*?>(.*?)</td>#', $tr, $match);
            $this->data[$i]['code'] =  preg_replace('#\&nbsp\;#','' ,$match[1][0] );
            $this->data[$i]['cname'] = preg_replace('#\&nbsp\;#','' ,$match[1][1] );
            $this->data[$i]['status'] = preg_replace('#\&nbsp\;#','' ,strip_tags($match[1][2]));
            $i++;
        }
//        var_dump($this->data);
        $html->clear();
    }

    function rebuildMsg()
    {
        $text = new Text();
        $text->content = "考勤信息：\n";
        for ($i = 0;$i<count($this->data);$i++)
        {
            $text->content .= '课程代码：'.iconv('GBK','UTF-8' ,$this->data[$i]['code'] )."\n".
                '课程名：'.iconv('GBK','UTF-8' ,$this->data[$i]['cname'] )."\n".
                '详情：'.iconv('GBK','UTF-8' ,$this->data[$i]['status'] )."\n\n";
        }
        return $text;
    }

}