<?php
namespace app\client\controller;
use think\Db;
use think\Request;
use think\Controller;
use app\client\common\Token;
class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        $header=Request::instance()->header();
        $id = Request::instance()->param('id');
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