<?php

namespace app\common\controller;
use think\Db;
use think\Request;
use think\Controller;
use app\client\common\Token;
class App extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $request = Request::instance();
        $header = $request->header();
        $id = $request->param('id');
        $type = $request->param('type');
        $res = $this->checkToken($header['token'],$id);
        if($res['code']==400){
            $data = [
                'code' => 400,
                'msg' => $res['msg'],
            ];
            $data = json_encode($data, 256);
            echo $data;
            exit;
        }

        if(is_null($type)){
            $data = [
                'code' => 400,
                'msg' => 'type不能位空！',
            ];
            $data = json_encode($data);
            echo $data;
            exit;
        }
    }

    public function checkToken($token,$id)
    {
        if ($token == 'null'){
            return format('Token不存在,拒绝访问', 400);
        }else{
            $user_info = Db::name('customer')->field('tel')->where('id',$id)->find();
            $checkJwtToken = Token::verifyJwt($token,$user_info['tel'],$user_info['tel'],$id);
            if ($checkJwtToken['code'] == 200) {
                return ['code'=>200,'msg'=>'ok'];
            }else{
                return ['code'=>400,'msg'=>$checkJwtToken['msg']];
            }
        }
    }
}