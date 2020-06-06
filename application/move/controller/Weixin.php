<?php
namespace app\move\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Config;
use think\Cache;
define('TOKEN','wechat_token');
header("content-type:text/html;charset=utf-8;");
class Weixin extends Controller
{
    public function index()
    {
        if(isset($_GET["echostr"])){

            Cache::set('test',$_GET);

            $this->valid();
        } else {
            $a = Cache::get('test');
            print_r($a);die;
            $this->responseMsg();
        }
    }
    public function valid()
    {
        $echostr = $_GET['echostr'];
        if($this->checkSignature()){
            echo $echostr;
            exit;
        }
    }

    public function responseMsg()
    {
        $postStr = file_get_contents("php://input");
        if (!empty($postStr)){
            echo '这里收到消息';
            exit;
        }else {
            echo '咋不说哈呢';
            exit;
        }
    }
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    public function saveFile($value)
    {
        file_put_contents("/xmlReceive.txt",$value."\r\n",FILE_APPEND);
        $fileName="xmlReceive.txt";
        $size = filesize($fileName);
        if($size>=10000)
        {
            unlink("/$fileName");
        }
        return 0;
    }
}