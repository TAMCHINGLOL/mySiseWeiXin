<?php
/**
 * Created by PhpStorm.
 * User: TAM_CHING_LOL
 * Date: 2016/5/31
 * Time: 12:47
 * 开设课程
 */
require_once 'simple_html_dom.php';
require_once 'AbstractMatchWebPage.php';

class CourseMathWebPage extends AbstractMatchWebPage
{
    function matchMsg($url, $cookie)
    {
//        $url = "http://class.sise.com.cn:7001//sise/module/selectclassview/selectclasscourse_view.jsp";
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $bi = $html->find('table',5);
        $yi = $html->find('table',7);
        $this->bi($bi);
        $this->yi($yi);

    }

    function rebuildMsg()
    {
        // TODO: Implement rebuildMsg() method.
    }

    //必修课
    function bi($bi)
    {
//        $arr = array();
        $n = 0;
        preg_match_all('#<td[^>]*?>(?:.*?)</td>#',$bi,$match);

        for($i=1;$i<count($match[0]);$i=$i+7)
        {
           $this->data['bi'][$n]['type'] = "必修";
           $this->data['bi'][$n]['code'] = strip_tags($match[0][$i]);
           $this->data['bi'][$n]['cname'] = strip_tags($match[0][$i+1]);
           $this->data['bi'][$n]['credit'] = strip_tags($match[0][$i+2]);
           $this->data['bi'][$n]['way'] = strip_tags($match[0][$i+3]);
           $this->data['bi'][$n]['pre'] = strip_tags($match[0][$i+4]);
           $this->data['bi'][$n]['same'] = strip_tags($match[0][$i+5]);
//       $this->data['bi'][$n]['null'] = strip_tags($match[0][$i+6]);
            $n++;
        }
//    var_dump($match);
//        var_dump($this->data);
    }
    //艺术限选
    function yi($yi)
    {
//       $this->data['bi'] = array();
        $n = 0;
        preg_match_all('#<td[^>]*?>(?:.*?)</td>#', $yi, $match);
        for ($i = 1; $i < count($match[0]); $i = $i + 7) {
           $this->data['yi'][$n]['type'] = "艺术";
           $this->data['yi'][$n]['code'] = strip_tags($match[0][$i]);
           $this->data['yi'][$n]['cname'] = strip_tags($match[0][$i + 1]);
           $this->data['yi'][$n]['credit'] = strip_tags($match[0][$i + 2]);
           $this->data['yi'][$n]['way'] = strip_tags($match[0][$i + 3]);
           $this->data['yi'][$n]['pre'] = strip_tags($match[0][$i + 4]);
           $this->data['yi'][$n]['same'] = strip_tags($match[0][$i + 5]);
//       $this->data['yi'][$n]['null'] = strip_tags($match[0][$i+6]);
            $n++;
        }
    }
}