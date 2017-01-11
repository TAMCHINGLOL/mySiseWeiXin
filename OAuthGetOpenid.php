<?php
/**
 * Created by PhpStorm.
 * User: TAM_CHING_LOL
 * Date: 2016/5/30
 * Time: 19:25
 */
class GetOpenId{
    function getUserInfo($code)
    {
        //开发者/测试号的appid和appsecret
        $appid = "wxe9bd24bee36b8753";
        $appsecret = "a425d454965bf936af081a1d206ce768";

        //第2步:使用code换取access_token
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $access_token_json = $this->https_request($access_token_url);
        $access_token_array = json_decode($access_token_json,true);
        //$access_token = $access_token_array['access_token'];
        $openid = $access_token_array['openid'];

        //第3步:使用access_token和openid获取用户信息
        //方式1：
        //$userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
        //方式2：
        $access_token2_url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $access_token2_json= $this->https_request($access_token2_url);
        $access_token2_array= json_decode($access_token2_json,true);
        $access_token2 = $access_token2_array['access_token'];
        $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token2&openid=$openid&lang=zh_CN";

        $userinfo_json = $this->https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json,true);
        return $userinfo_array;
    }

    function https_request($url)
    {
        $curl = curl_init();									//初始化一个cURL会话
        curl_setopt($curl, CURLOPT_URL, $url);						//要获取的URL地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);		//禁止 cURL 验证对等证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);		//禁止检查服务器SSL证书中是否存在一个公用名(common name)
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			//返回原生的输出
        $data = curl_exec($curl);								//抓取URL并把它传递给浏览器
        if(curl_errno($curl)){									//返回最后一次的错误号
            return 'ERROR'.curl_error($curl);					//返回一个保护当前会话最近一次错误的字符串
        }
        curl_close($curl);										// 关闭一个cURL会话
        return $data;
    }
}