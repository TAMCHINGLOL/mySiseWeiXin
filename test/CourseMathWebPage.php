<?php
/**
 * Created by PhpStorm.
 * User: TAM_CHING_LOL
 * Date: 2016/5/31
 * Time: 12:47
 */
require_once 'simple_html_dom.php';
require_once 'AbstractMatchWebPage.php';

/*class CourseMathWebPage extends AbstractMatchWebPage
{
    function matchMsg($url, $cookie)
    {
       // $url = "http://class.sise.com.cn:7001//sise/module/selectclassview/selectclasscourse_view.jsp";
        $content = $this->getUrlContent($url,null,$cookie,0,1,0);
        $html = new simple_html_dom();
        $html->load($content);
        $tds = $html->find('tr td.tablebody');
        print_r($tds);
//        foreach ($tds as $td) {
//            $td = preg_replace('#<a[^>]*>(.*?)</a>#', "$1", $td);
////            echo $td;
//            preg_match_all('#<td[^>]*>(.*?)</td>#', $td, $match);
//            // print_r($match);
//            $arr = $match[1];
//            var_dump($arr);
    //    }

    }

    function rebuildMsg()
    {
        // TODO: Implement rebuildMsg() method.
    }
}*/