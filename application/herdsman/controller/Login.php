<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/26
 * Time: 18:21
 */

namespace app\herdsman\controller;
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with, content-type,token');
use app\client\common\Token;
use app\common\model\Customer;
use app\common\model\Herdsman;
use think\Cache;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{
    public function index(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.login');
            if(true !== $result) return format($result, 400);
            $res = Herdsman::dologin($data);
            if($res['code']==200){
                $userInfo = $res['data'];
                $token = Token::createJwt($userInfo['id'],$userInfo['tel'],$userInfo['tel']);
                Cache::set('user'.$userInfo['id'],$token,3600);
                return format('', 200,['id'=>$userInfo['id'],'token'=>$token]);
            }else{
                return format($res['msg'], 400);
            }
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }

}