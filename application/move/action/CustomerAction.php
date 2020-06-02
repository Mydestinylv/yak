<?php

namespace app\move\action;

use app\common\controller\Phonecode;
use app\common\lib\Transfer;
use app\common\sub_action\CustomerSubAction;
use app\common\task\CustomerTask;
use think\Cookie;

class CustomerAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {

        return new Transfer('', true);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {

        return new Transfer('', true);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {

        return new Transfer('', true);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {

        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function sendSms($param,$customer_id)
    {
        $trasnfer = CustomerTask::valueByWhere(['id'=>$customer_id],'tel');
        if(!$trasnfer->status){
            return new Transfer('重置密码失败');
        }
        if(!$trasnfer->data['tel']){
            return new Transfer('手机号错误');
        }
        $code = mt_rand(1000,9999);
        Cookie::set('code_'.$customer_id,$code);
        $trasnfer = Phonecode::sendSms('17378516325',$code);
        $trasnfer = json_decode(json_encode($trasnfer,true),true);
        if($trasnfer['Code']!='OK'){
            return new Transfer('发送短信失败');
        }
        return new Transfer('',true);
    }

    /**
     * 修改密码
     */
    public static function changePassword($param,$where,$type)
    {
        $trasnfer = CustomerSubAction::changePassword($param,$where,$type);
        if(!$trasnfer->status){
            return new Transfer($trasnfer->message);
        }
        return new Transfer('', true);
    }

    /**
     * 重置密码
     */
    public static function passwordReset($param,$customer_id)
    {
        $code = Cookie::get('code_'.$customer_id);
        if($param['code']!=$code){
            return new Transfer('验证码错误');
        }
        Cookie::delete('code_'.$customer_id);
        $param['id'] = $customer_id;
        $trasnfer = CustomerSubAction::passwordReset($param);
        if(!$trasnfer->status){
            return new Transfer($trasnfer->message);
        }
        return new Transfer('', true);
    }

    /**
     * 用户信息
     */
    public static function userInfo($param,$where,$type)
    {
        $trasnfer = CustomerSubAction::userInfo($param,$where,$type);
        if(!$trasnfer->status){
            return new Transfer($trasnfer->message);
        }
        return new Transfer('', true, $trasnfer->data);
    }

}
