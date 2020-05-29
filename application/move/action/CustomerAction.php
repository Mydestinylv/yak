<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\CustomerSubAction;

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
    public static function delete($param)
    {

        return new Transfer('', true);
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
