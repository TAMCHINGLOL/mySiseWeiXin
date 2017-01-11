<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/20
 * Time: 14:38
 */
include __DIR__ . '/vendor/autoload.php'; // 引入 composer 入口文件
require_once 'sise/SchedularMatchWebPage.php';
require_once 'sise/MatchControler.php';
require_once 'sise/DatabaseManager.php';
require_once 'sise/AttendMatchWebPage.php';
require_once 'sise/ExamMatchWebPage.php';
require_once 'sise/LateMatchWebPage.php';
require_once 'sise/EncourageMatchWebPage.php';
require_once 'isBindLogin.php';
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;

$options = [
    'debug'  => true,
    'app_id' => 'wxe9bd24bee36b8753',
    'secret' => 'a425d454965bf936af081a1d206ce768',
    'token'  => 'sise',

    // 'aes_key' => null, // 可选

    'log' => [
        'level' => 'debug',
        'file'  => 'E:\xampp\htdocs\log\easywechat.log', // XXX: 绝对路径！！！！
    ],
];

//初始化
$app = new Application($options);
$server = $app->server;

//消息事件处理
$server->setMessageHandler(function($message){

    switch ($message->MsgType)
    {
        #消息事件
        case 'event':
            switch ($message->Event)
            {
                case 'subscribe':
                    $text = new Text();
                    $text->content="亲，感谢您的关注！绑定账号，可以获得更多有趣的功能哦！\n绑定回复：学号+密码。\n例如：\nxxxxxxxxxx+xxxxxx";
                    return $text;
                case 'unsubscribe':
                    $dbm = new DatabaseManager();
                    $dbm->delete($message->FromUserName);
                    break;
                //处理菜单按钮时间
                case 'CLICK':
                    switch ($message->EventKey)
                    {
                        //绑定账号
                        case 'btn_bind':

                            return "绑定账号请回复：学号+密码。\n例如：\nxxxxxxxxxx+xxxxxx";
                        //解除绑定
                        case 'btn_unbind':
                            $dbm = new DatabaseManager();
                            if ($dbm->delete($message->FromUserName))
                            {
                                return '解绑成功!';
                            }else{
                                return '解绑失败，数据库操作错误！';
                            }

                        //个人信息
                        case 'btn_info':
                            return ;
                        //课表-周一
                        case 'btn_schedular_1':
                            return schedular($message->FromUserName,1 );

                        //课表-周二
                        case 'btn_schedular_2':
                            return schedular($message->FromUserName,2 );
                        //课表-周三
                        case 'btn_schedular_3':
                            return schedular($message->FromUserName,3 );
                        //课表-周四
                        case 'btn_schedular_4':
                            return schedular($message->FromUserName,4 );
                        //课表-周五
                        case 'btn_schedular_5':
                            return schedular($message->FromUserName,5 );
                        //考勤
                        case 'btn_attend':
                            $result = login(isBind($message->FromUserName));
                            if (is_object($result))
                            {
                                $attend = new AttendMatchWebPage();
                                $attend->matchMsg($result->getLinks()['attend'],$result->getCookie() );
                                return $attend->rebuildMsg();

                            }else{
                                return '请先绑定账户！';
                            }

                        //考试时间
                        case 'btn_exam':
                            $result = login(isBind($message->FromUserName));
                            if (is_object($result))
                            {
                                $exam = new ExamMatchWebPage();
                                $exam->matchMsg($result->getLinks()['exam'],$result->getCookie() );
                                return $exam->rebuildMsg();

                            }else{
                                return '请先绑定账户！';
                            }
                        //奖惩记录
                        case 'btn_encourage':
                            $result = login(isBind($message->FromUserName));
                            if (is_object($result))
                            {
                                $encourage = new EncourageMatchWebPage();
                                $encourage->matchMsg($result->getLinks()['encourage'],$result->getCookie() );
                                return $encourage->rebuildMsg();

                            }else{
                                return '请先绑定账户！';
                            }

                        //晚归违规
                        case 'btn_late':
                            $result = login(isBind($message->FromUserName));
                            if (is_object($result))
                            {
                                $late = new LateMatchWebPage();
                                $late->matchMsg($result->getLinks()['late'],$result->getCookie() );
                                return $late->rebuildMsg();

                            }else{
                                return '请先绑定账户！';
                            }
                    }
            }
            break;
            # 文字消息
        case 'text':

            if (preg_match('#(^\d{10})\+#',$message->Content))
            {
                $arr = explode('+',$message->Content);
                $username =  $arr[0];
                $password =  $arr[1];
                $control = new MatchControler();
                if ($control->checkLoginAndGetCookie($username, $password))
                {
                    $dbm = new DatabaseManager();
                    $res = $dbm->add($message->FromUserName, $username, $password);
                    if ($res)
                    {
                        return '绑定成功!';
                    }else
                    {
                        return '绑定失败，不能重复绑定!';
                    }
                }else{
                    return '学号或密码不正确！';
                }
            }else{
                return '请输入正确的学号';
            }

        default:
            return '更多功能正在开发中...尽请期待！';
            break;

    }
});

// 将响应输出
$server->serve()->send();

//课程表
function schedular($openid,$day)
{
    $result = login(isBind($openid));
    if (is_object($result))
    {
        $schedular = new SchedularMatchWebPage();
        $schedular->matchMsg($result->getLinks()['schedular'], $result->getCookie());
        return $schedular->week($day);

    }else{
        return '请先绑定账户！';
    }
}

