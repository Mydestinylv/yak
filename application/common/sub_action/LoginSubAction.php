<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\AdminUserTask;
use think\Cookie;

class LoginSubAction
{
    /**
     * 显示资源列表
     */
    public static function login($param)
    {
        $where['account'] = $param['account'];
        $transfer = AdminUserTask::find($where,'id,salt,password');
        if(empty($transfer->data['salt'])||empty($transfer->data['password'])){
            return new Transfer('账号不存在');
        }
        if(password_encryption($param['password'],$transfer->data['salt'])!=$transfer->data['password']){
            return new Transfer('账号或密码错误');
        }
        $data['user_id'] = $transfer->data['id'];

        Cookie::delete('access_token_admin');
        $transfer = get_token();
        if (!$transfer->status) {
            return $transfer;
        }
        $access_token = $transfer->data['access_token'];
        Cookie::set('access_token_admin',$access_token,'7200');
        Cookie::set($access_token,$data['user_id'],'7200');
        $data['access_token'] = $access_token;
        return new Transfer('登陆成功', true, $data);
    }
}
