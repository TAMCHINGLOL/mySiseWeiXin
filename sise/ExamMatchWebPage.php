<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/22
 * Time: 20:36
 * Event：考试时间
 */
//include 'simple_html_dom.php';
use EasyWeChat\Message\Text;
class ExamMatchWebPage extends AbstractMatchWebPage
{
    function matchMsg($url, $cookie)
    {
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $table = $html->find('table',4);
        preg_match_all('#<td[^>]*?>(.*?)</td>#',$table,$match);
        $tds = $match[1];
//        $this->data = array();
        $n = 0;
        for ($i=0;$i<count($tds);$i=$i+8)
        {
            $this->data[$n]['code']=$tds[$i];
            $this->data[$n]['cname']=$tds[$i+1];
            $this->data[$n]['date']=$tds[$i+2];
            $this->data[$n]['time']=$tds[$i+3];
            $this->data[$n]['examcode']=$tds[$i+4];
            $this->data[$n]['examroom']=$tds[$i+5];
            $this->data[$n]['seat']=$tds[$i+6];
            $this->data[$n]['status']=$tds[$i+7];
            $n++;
        }
        $html->clear();
        var_dump($this->data);
    }

    function rebuildMsg()
    {
        $text = new Text();
        $text->content = "考试时间\n";
        for ($i = 0;$i<count($this->data);$i++)
        {
            $text->content .= '课程代码:'.iconv('GBK','UTF-8' ,$this->data[$i]['code'] )."\n".
                              '课程名：'.iconv('GBK','UTF-8' ,$this->data[$i]['cname'] )."\n".
                              '考试日期：'.iconv('GBK','UTF-8' ,$this->data[$i]['date'] )."\n".
                              '考试时间：'.iconv('GBK','UTF-8' ,$this->data[$i]['time'] )."\n".
                              '考场编码：'.iconv('GBK','UTF-8' ,$this->data[$i]['examcode'] )."\n".
                              '考场名称：'.iconv('GBK','UTF-8' ,$this->data[$i]['examcode'] )."\n".
                              '考试座位：'.iconv('GBK','UTF-8' ,$this->data[$i]['seat'] )."\n".
                              '考试状态：'.iconv('GBK','UTF-8' ,$this->data[$i]['status'] )."\n\n";
        }
        return $text;
    }
}