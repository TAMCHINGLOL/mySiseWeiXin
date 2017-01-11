<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/23
 * Time: 9:39
 */
$str = '{
    "button": [
        {
            "name": "账户",
            "sub_button": [
                {
                    "type": "click",
                    "name": "绑定账户",
                    "key": "btn_bind"
                },
                {
                    "type": "click",
                    "name": "解除绑定",
                    "key": "btn_unbind"
                },
                {
                    "type": "view",
                    "name": "个人信息",
                    "url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe9bd24bee36b8753&redirect_uri=http://dd.ngrok.csuki.cc.ngrok.csuki.cc/wx_sise/info.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect"
                }
            ]
        },
        {
            "name": "课程表",
            "sub_button": [
                {
                    "type": "click",
                    "name": "星期一",
                    "key": "btn_schedular_1"
                },
                {
                    "type": "click",
                    "name": "星期二",
                    "key": "btn_schedular_2"
                },
                {
                    "type": "click",
                    "name": "星期三",
                    "key": "btn_schedular_3"
                },
                {
                    "type": "click",
                    "name": "星期四",
                    "key": "btn_schedular_4"
                },
                {
                    "type": "click",
                    "name": "星期五",
                    "key": "btn_schedular_5"
                }
            ]
        },
        {
            "name": "查询",
            "sub_button": [
                {
                    "type": "click",
                    "name": "考勤信息",
                    "key": "btn_attend"
                },
                {
                    "type": "click",
                    "name": "考试时间",
                    "key": "btn_exam"
                },
                {
                    "type": "click",
                    "name": "奖惩记录",
                    "key": "btn_encourage"
                },
                {
                    "type": "click",
                    "name": "晚归违规",
                    "key": "btn_late"
                },
                {
                    "type": "view",
                    "name": "开设课程",
                    "url": "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe9bd24bee36b8753&redirect_uri=http://dd.ngrok.csuki.cc.ngrok.csuki.cc/wx_sise/courses.php&response_type=code&scope=snsapi_base&state=1#wechat_redirect"
                }
            ]
        }
    ]
}';
