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
        $transfer = CustomerTask::valueByWhere(['id'=>$customer_id],'tel');
        if(!$transfer->status){
            return new Transfer('重置密码失败');
        }
        if(!$transfer->data['tel']){
            return new Transfer('手机号错误');
        }
        $code = mt_rand(1000,9999);
        Cookie::set('code_'.$customer_id,$code);
        $transfer = Phonecode::sendSms($transfer->data['tel'],$code);
        $transfer = json_decode(json_encode($transfer,true),true);
        if($transfer['Code']!='OK'){
            return new Transfer('发送短信失败');
        }
        return new Transfer('',true);
    }

    /**
     * 修改密码
     */
    public static function changePassword($param,$where,$type)
    {
        $transfer = CustomerSubAction::changePassword($param,$where,$type);
        if(!$transfer->status){
            return new Transfer($transfer->message);
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
        $transfer = CustomerSubAction::passwordReset($param);
        if(!$transfer->status){
            return new Transfer($transfer->message);
        }
        return new Transfer('', true);
    }

    /**
     * 用户信息
     */
    public static function userInfo($param,$where,$type)
    {
        $transfer = CustomerSubAction::userInfo($param,$where,$type);
        if(!$transfer->status){
            return new Transfer($transfer->message);
        }
        return new Transfer('', true, $transfer->data);
    }

}
