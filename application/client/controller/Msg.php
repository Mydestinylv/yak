<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/29
 * Time: 11:17
 */

namespace app\client\controller;


use app\common\controller\App;
use app\common\model\Chat;
use think\Request;

class Msg extends App
{
    /*
     * 接收消息
     * */
    public function index(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Msg.index');
            if(true !== $result) return format($result, 400);
            $list = Chat::GetUserMsg($data,CID);
            if($list['code']==400){
                return format($list['meg']);
            }else{
                return format('ok',200,$list['msg']);
            }
        }
    }
    /*
     * 发送消息
     * */
    public function send_msg(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Msg.send');
            if(true !== $result) return format($result, 400);
            $list = Chat::UserSendMsg($data,CID);
            if($list['code']==400){
                return format($list['meg']);
            }else{
                return format('ok',200,$list['msg']);
            }
        }
    }

    /*
     * 用户获取聊天列表
     * */
    public function get_list(Request $request)
    {
        $id =$request->param('id');
        $list = Chat::UserGetMsgList($id);
        if($list['code']==400){
            return format($list['msg']);
        }else{
            return format('ok',200,$list['msg']);
        }
    }
}