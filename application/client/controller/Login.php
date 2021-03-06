<?php
namespace app\client\controller;
use app\client\common\Token;
use app\common\controller\Phonecode;
use app\common\model\Customer;
use app\common\service\WechatPayService;
use app\common\task\CustomerTask;
use app\common\task\WechatTask;
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
                Cache::set($token,$userInfo['id'],3600);
                Cache::set('type'.$token,1,3600);
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
            $cache_code = Cache::get('register'.$data['tel']);
            if(!$cache_code || $cache_code != $data['code']) return format('短信验证码验证失败！');
            Cache::rm('register'.$data['tel']);
            $password = pswCrypt($data['password']);
            $data['password'] = $password;
            unset($data['repassword']);
            $res = Customer::UserRegister($data);
            return $res['code']==200 ? format('ok', 200) : format($res['msg'], 400);
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }

    public function send_msg(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.login');
            if(true !== $result) return format($result, 400);
            $code = rand(1000,9999);
            try{
                $msg = Phonecode::sendSms($data['tel'],$code,'四川牦牛哥');
            }catch (\Exception $e){
                return format($e->getMessage(),400);
            }
            $msg = json_decode(json_encode($msg,true),true);
            if($msg['Code']=='OK') {
                Cache::set('register'.$data['tel'],$code,3*60);
                return format('ok',200,$msg);
            }else{
                return format('短信发送失败！',400);
            }

        }
    }

    public function wechatRegister(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.wechatRegister');
            if(true !== $result) return format($result, 400);
            //没有使用短信验证码，暂无验证
            $cache_code = Cache::get('register'.$data['tel']);
            if(!$cache_code || $cache_code != $data['code']) return format('短信验证码验证失败！');
            Cache::rm('register'.$data['tel']);
            $res = Customer::UserRegister($data);
            return $res['code']==200 ? format('ok', 200) : format($res['msg'], 400);
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }

    public function wechatLogin(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Login.wechatLogin');
            if(true !== $result) return format($result, 400);
            $open_id = WechatPayService::getOpenIds($data['code']);
            $transfer = WechatTask::find(['open_id'=>$open_id],'id,customer_id');
            if(!$transfer->status){
                return format('登录失败',400);
            }
            $transfer = CustomerTask::find(['id'=>$transfer->data['customer_id']],'id,tel');
            if(!$transfer->status){
                return format('登录失败',400);
            }
            if(!$transfer->data){
                return format('请注册后登录',400, ['open_id'=>$open_id]);
            }
            $userInfo = to_array($transfer->data);
            $token = Token::createJwt($userInfo['id'],$userInfo['tel'],$userInfo['tel']);
            Cache::set('user'.$userInfo['id'],$token,3600);
            Cache::set($token,$userInfo['id'],3600);
            Cache::set('type'.$token,1,3600);
            return format('',200,['id'=>$userInfo['id'],'token'=>$token,'open_id'=>$open_id]);
        }else{
            return format('error,请正确请求接口！', 400);
        }
    }
}