<?php
namespace app\herdsman\controller;
use app\common\controller\App;
use app\common\model\Chat;
use think\Request;

class Msg extends App
{
    /*
     * 接收消息
     * */
    public function msg_list(Request $request)
    {
        if($request->isPost()){
            $data = $request->param();
            $result = $this->validate($data,'Msg.index');
            if(true !== $result) return format($result, 400);
            $list = Chat::GetHerdsmanMsg($data,HID);
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
            $list = Chat::HerdsmanSendMsg($data,HID);
            if($list['code']==400){
                return format($list['meg']);
            }else{
                return format('ok',200,$list['msg']);
            }
        }
    }

    /*
     * 消息列表
     * */

    public function index(Request $request)
    {
        $type = TYPE;
        switch ($type){
            case 1:
                $id = CID;
                break;
            case 2:
                $id = HID;
                break;
            case 3:
                $id = SID;
                break;
            default:
                return format('参数错误',400);
        }
        $list = Chat::HGetMsgList($id);
        if($list['code']==400) {
            return format($list['msg']);
        }else{
            return format('ok',200,$list['msg']);
        }
    }
}