<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/4/24
 * Time: 15:39
 */


abstract class AbstractMatchWebPage
{
    //存储数据数组变量
    protected $data = array();

    //爬取信息,并存储到$data数组变量中
    abstract protected function matchMsg($url,$cookie);

    //将爬取的$data重组成微信使用的格式
    abstract protected function rebuildMsg();

    //获取data
    function getData()
    {
        return $this->data;
    }


    //使用curl获取网页内容
    protected function getUrlContent($url, $postData = null, $cookie = null, $isPostData = 0, $isSetCookie = 0, $isSetHeader = 0)
    {
        //curl 初始化
        $ch = curl_init();
        //请求url
        curl_setopt($ch, CURLOPT_URL, $url);
        //输出header部分"
        curl_setopt($ch, CURLOPT_HEADER, $isSetHeader);
        //返回输出流
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置cookie
        if($isSetCookie)
        {
            curl_setopt($ch,CURLOPT_COOKIE,$cookie);
        }
        //设置post提交数据
        if($isPostData)
        {
            //post提交方式
            curl_setopt($ch, CURLOPT_POST, 1);
            //post提交的数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        //执行curl
        $content = curl_exec($ch);
        //释放资源
        curl_close($ch);

        return $content;
    }
}