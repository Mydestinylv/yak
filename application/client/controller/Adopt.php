<?php
namespace app\client\controller;
use app\common\controller\App;
use think\Request;

class Adopt extends App
{
    public function index( Request $request)
    {
        if($request->isPost()){
            return format('error,请正确请求接口！', 400);
        }
    }
}