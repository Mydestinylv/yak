<?php
namespace app\move\controller;
use app\client\common\Token;
use app\common\service\WechatPayService;
use think\Cache;
use app\common\model\SlaughterMan;
use think\Config;
use think\Controller;
use think\Request;

class Login extends Controller
{
    public function index(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'app\client\validate\Login.login');
            if(true !== $result) return format($result, 400);
            $res = SlaughterMan::dologin($data);
            if($res['code']==200){
                $userInfo = $res['data'];
                $token = Token::createJwt($userInfo['id'],$userInfo['tel'],$userInfo['tel']);
                Cache::set('user'.$userInfo['id'],$token,3600);
                Cache::set($token,$userInfo['id'],3600);
                Cache::set('type'.$token,3,3600);
                return format('', 200,['id'=>$userInfo['id'],'token'=>$token]);
            }else{
                return format($res['msg'], 400);
            }
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }

    public function getOpenId()
    {
        $transfer = WechatPayService::getOpenId();
        if($transfer){
            return format('',200,$transfer);
        }else{
            return format('',400);
        }
    }
}