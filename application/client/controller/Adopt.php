<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/22
 * Time: 16:43
 */

namespace app\client\controller;
use think\Request;

class Adopt extends Base
{
    public function index( Request $request)
    {
        if($request->isPost()){
            return format('error,请正确请求接口！', 400);
        }
    }
}