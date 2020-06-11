<?php
namespace app\herdsman\controller;
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
                Cache::set($token,$userInfo['id'],3600);
                Cache::set('type'.$token,2,3600);
                return format('', 200,['id'=>$userInfo['id'],'token'=>$token]);
            }else{
                return format($res['msg'], 400);
            }
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }

}