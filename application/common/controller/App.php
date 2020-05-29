<?php

namespace app\common\controller;
use think\Cache;
use think\Db;
use think\Env;
use think\Request;
use think\Controller;
use app\client\common\Token;
class App extends Controller
{
    public function _initialize()
    {
        define('CID',4);
        define('TYPE',1);
        $temp = $this->check_environment();
        if ($temp) {
            //  goto sub_permission;
            return true;
        }
        parent::_initialize();
        $request = Request::instance();
        $token = $request->header('token');
        if(is_null($token)) {
            $data = json_encode(['status' => 400,'msg' => '请传入token',], 256);echo $data;exit;
        }
        $id = $request->param('id');
        $type = $request->param('type');
        if(!in_array($type,[1,2,3])) {
            $data = json_encode(['status' => 400,'msg' => 'type参数传入错误',], 256);echo $data;exit;
        }
        $res = $this->checkToken($token,$id,$type);
        if($res['code']==400){
            $data = json_encode(['status' => 400, 'msg' => $res['msg'],], 256);echo $data;exit;
        }
        if(is_null($type)){
            $data = json_encode(['status' => 400,'msg' => 'type不能位空！',]);echo $data;exit;
        }else{
            switch ($type){
                case 1 :
                    define('CID', $id);
                    break;
                case 2 :
                    define('HID',$id);
                    break;
                case 3 :
                    define('SID',$id);
                    break;
                default :
                    $data = [
                        'status' => 400,
                        'msg' => 'type错误，请确认！',
                    ];
                    $data = json_encode($data,256);
                    echo $data;
                    exit;
            }
        }
    }

    public function checkToken($token,$id,$type)
    {
        if ($token == 'null'){
            return format('Token不存在,拒绝访问', 400);
        }else{
            $arr = [1=>'customer',2=>'herdsman',3=>'slaughter_man'];
            $user_info = Db::name($arr[$type])->field('tel')->where('id',$id)->find();
            $hasCache = Cache::get('user'.$id);
            if(!$hasCache) return ['code'=>400,'msg'=>'登陆过期！'];
            $checkJwtToken = Token::verifyJwt($token,$user_info['tel'],$user_info['tel'],$id);
            if ($checkJwtToken['code'] == 200) {
                Cache::rm('user'.$id);
                Cache::set('user'.$id,$token,3600);
                return ['code'=>200,'msg'=>'ok'];
            }else{
                return ['code'=>400,'msg'=>$checkJwtToken['msg']];
            }
        }
    }

    public function check_environment()
    {
        if (Env::get('environment') === 'test') {
            $this->environment = 'test';
        }else{
            return false;
        }
        return true;
    }
}