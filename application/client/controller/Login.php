<?php
namespace app\client\controller;
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with, content-type,token');
use app\client\common\Token;
use app\common\controller\Phonecode;
use app\common\model\Customer;
use think\Cache;
use think\Controller;
use think\Request;

class Login extends Controller
{
    public function index(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.login');
            if(true !== $result) return format($result, 400);
            $res = Customer::dologin($data);
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

    public function register(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.register');
            if(true !== $result) return format($result, 400);
            //没有使用短信验证码，暂无验证
            $password = pswCrypt($data['password']);
            $data['password'] = $password;
            $res = Customer::UserRegister($data);
            return $res['code']==200 ? format('ok', 200) : format($res['msg'], 400);
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }

    public function send_msg(Request $request)
    {
//        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.login');
            if(true !== $result) return format($result, 400);
            $code = rand(1000,9999);
            try{
                $msg = Phonecode::sendSms($data['tel'],$code,'四川牦牛哥');
            }catch (\Exception $e){
                return format($e->getMessage(),400);
            }
            return format('ok',200,$msg);
//        }
    }

}