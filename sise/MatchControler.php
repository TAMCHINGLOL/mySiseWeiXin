<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/4/24
 * Time: 16:18
 */

class MatchControler
{
    //登陆页面的name value值
    private $name = null;
    private $value = null;

    //登录成功后获取的cookie值
    private $cookie = null;

    //主页的链接
    private $links = array();

    //初始化
//    function __construct()
//    {
//    }
    

    //登录并获取登录成功后的cookie
    function checkLoginAndGetCookie($username,$password)
    {

        $this->getNameValue();

        //登录时要提交的数据
        $postData = "username=$username&password=$password&$this->name=$this->value";

        //登录时要提交的数据
//        $postData = "username=$username&password=$password&44d4794b5b3caeec124dd344919cfeb6=caf51d5f96e5db4344e004aa5d380586";
//        $postData = "username=1340112222&password=lcc2789.&cbb38ac75f0f9406b2bab3b9ffb48488=29716dc47e2cec59eceb01e036e23ee9";
        //登录验证url
        $url = "http://class.sise.com.cn:7001/sise/login_check.jsp";
        //登录
        $content = $this->getUrlContent($url, $postData, null, 1, 0, 1);

        //判断转向地址是否为成功登录的转向地址（即验证是否可以成功登录）
        preg_match('/<script>(.*?)<\/script>/', $content, $match);
        $result = $match[1];
        if (strpos($result, "/sise/index.jsp") == true) {
            //登录成功
            //获取cookie
            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
            //将sessionID赋给$cookie变量
            $this->cookie = $str[1];
            //获取其他页面的链接
            $this->getLinks();
            return true;
        } else {
            //登录失败
            //截取失败信息
//            echo substr($result, strpos($result, "messages=") + 9, count(substr) - 3);
            echo "Login Error:Make sure the account is right!";
            return false;
        }
    }

    //登陆后获取相应链接
    function getMainPageLinks()
    {
       if (isset($this->cookie))
       {
           $url = 'class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp';
           $content = $this->getUrlContent($url,null,$this->cookie,0,1,1);
           preg_match_all('#onclick=[^\'](?:.*?)\'(.*?)\'#',$content,$match);
           
           $this->links['info']='http://class.sise.com.cn:7001/'.$match[1][0];
           $this->links['schedular']='http://class.sise.com.cn:7001/'.$match[1][1];
           $this->links['attend']='http://class.sise.com.cn:7001/'.$match[1][3];
           $this->links['exam']='http://class.sise.com.cn:7001/'.$match[1][2];
           $this->links['commonresult']='http://class.sise.com.cn:7001/'.$match[1][4];
           $this->links['encourage']='http://class.sise.com.cn:7001/'.$match[1][5];
           $this->links['classview']='http://class.sise.com.cn:7001/'.$match[1][10];
           $this->links['late']='http://class.sise.com.cn:7001/'.$match[1][22];
       }
    }

    //获取登录首页的name value
    function getNameValue()
    {
        $url = 'http://class.sise.com.cn:7001/sise/login.jsp';
        $NameValue = $this->getUrlContent($url);
        $html = new simple_html_dom();
        $html->load($NameValue);
        $input = $html->find('input',0);
        preg_match_all('#name="(.*?)"|value="(.*?)"#',$input,$match );
//        var_dump($match);
        $this->name =  $match[1][0];
        $this->value = $match[2][1];
    }

    //返回获取的cookie值
    function getCookie()
    {
        return $this->cookie;
    }
    //返回links
    function getLinks()
    {
        return $this->links;
    }
    //使用curl进行请求处理并获取请求后的页面内容
    private function getUrlContent($url, $postData = null, $cookie = null, $isPostData = 0, $isSetCookie = 0, $isSetHeader = 0)
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
        if ($isSetCookie) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        //设置post提交数据
        if ($isPostData) {
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

    //调用相应的MatchWebPage类执行内容
    function invoke($matchWebPageObject)
    {
        $matchWebPageObject->rebuildMsg();
    }
}