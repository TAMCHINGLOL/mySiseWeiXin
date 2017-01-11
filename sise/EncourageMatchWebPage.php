<?php

/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/22
 * Time: 19:46
 * Event：奖惩记录
 */
use EasyWeChat\Message\Text;
class EncourageMatchWebPage extends AbstractMatchWebPage
{
    
    function matchMsg($url, $cookie)
    {
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $good = $html->find('table',3);
        $bad = $html->find('table',4);
        $this->good($good);
        $this->bad($bad);
    }

    function rebuildMsg()
    {
        $text = new Text();
        $text->content = "奖惩记录:\n\n";
        if (isset($this->data['good'][7]))
        {
            $text->content .= "奖励信息：\n";
            for ($i = 7;$i<count($this->data['good']);$i=$i+6)
            {
                $text->content .= "学年:".$this->data['good'][$i]."\n".
                                  "学期:".$this->data['good'][$i+1]."\n".
                                  "奖励级别:".$this->data['good'][$i+2]."\n".
                                  "奖励原因:".$this->data['good'][$i+3]."\n".
                                  "奖励单位/部门:".$this->data['good'][$i+4]."\n".
                                  "奖励日期:".$this->data['good'][$i+5]."\n\n";
            }
        }else{
            $text->content .= "奖励信息：\n暂无信息";
        }
        
        if (isset($this->data['bad'][9]))
        {
            $text->content .= "惩处信息：\n";
            for ($i = 9;$i<count($this->data['bad']);$i=$i+8)
            {
                $text->content .= "学年:".$this->data['bad'][$i]."\n".
                    "学期:".$this->data['bad'][$i+1]."\n".
                    "处分等级:".$this->data['bad'][$i+2]."\n".
                    "违纪原因:".$this->data['bad'][$i+3]."\n".
                    "处分发文单位/部门:".$this->data['bad'][$i+4]."\n".
                    "处分日期:".$this->data['bad'][$i+5]."\n".
                    "所在系意见:".$this->data['bad'][$i+6]."\n".
                    "意见人:".$this->data['bad'][$i+7]."\n\n";
            }
        }else{
            $text->content .= "惩处信息：\n暂无信息";
        }
        return $text;
    }


    //奖励记录
    function good($good)
    {
        $html = new simple_html_dom();

        $html->load("$good");
        $tds = $html->find('tr td');
        $n = 0;
        foreach ($tds as $td)
        {
            $this->data['good'][$n] = strip_tags($td);
            $n++;
        }
        $html->clear();
    }


    //惩罚记录
    function bad($bad)
    {
        $html = new simple_html_dom();
        $html->load("$bad");
        $tds = $html->find('tr td');

        $n =0;
        foreach ($tds as $td)
        {
            $this->data['bad'][$n] = strip_tags($td);
            $n++;
        }
        $html->clear();
    }
}