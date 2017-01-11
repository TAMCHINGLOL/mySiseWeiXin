<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 2016/5/22
 * Time: 13:07
 */
header("Content-Type:text/html;charset=utf-8");
require_once 'sise/MatchControler.php';
require_once 'sise/InfoMatchWebPage.php';
require_once 'sise/SchedularMatchWebPage.php';
require_once 'sise/LateMatchWebPage.php';
require_once 'sise/AttendMatchWebPage.php';
require_once 'sise/EncourageMatchWebPage.php';
require_once 'sise/ExamMatchWebPage.php';
require_once 'sise/CourseMathWebPage.php';



$control = new MatchControler();
$control->checkLoginAndGetCookie('1340112222','lcc2789.');
//$control->getMainPageLinks();
//var_dump($control->getLinks());


$info = new InfoMatchWebPage();
$info->matchMsg($control->getLinks()['info'],$control->getCookie() );
//var_dump($info->getData());
//$schedular = new SchedularMatchWebPage();
//$schedular->matchMsg($control->getLinks()['schedular'], $control->getCookie());
//var_dump($schedular->getData());
//$schedular->monday();

//$exam = new ExamMatchWebPage();
//$exam->matchMsg($control->getLinks()['exam'],$control->getCookie() );
//var_dump($exam->getData());

//$attend = new AttendMatchWebPage();
//$attend->matchMsg($control->getLinks()['attend'],$control->getCookie() );
//var_dump($attend->getData());

//$encourage = new EncourageMatchWebPage();
//$encourage->matchMsg($control->getLinks()['encourage'],$control->getCookie() );
//var_dump($encourage->getData());

//$late = new LateMatchWebPage();
//$late->matchMsg($control->getLinks()['late'],$control->getCookie() );
//var_dump($late->getData());

$course = new CourseMathWebPage();
$course->matchMsg($control->getLinks()['classview'],$control->getCookie() );
//var_dump($late->getData());
