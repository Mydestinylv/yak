<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/29
 * Time: 16:18
 */

namespace app\client\controller;


use think\Controller;

class Weixin extends Controller
{
    public function index(){
        $this->valid();
    }

    //微信验证
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    //检查微信签名
    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
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
}