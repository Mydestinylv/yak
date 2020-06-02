<?php
namespace app\move\controller;
use think\Controller;
use think\Session;
use think\Db;
define("TOKEN", "weixin");//自己定义的token 就是个通信的私钥
header("content-type:text/html;charset=utf-8;");
class Weixin extends Controller
{
    public function index()
    {
        if(isset($_GET["echostr"])){
            $this->valid();
        } else {
            $this->responseMsg();
        }
    }
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
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
        $token =TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
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