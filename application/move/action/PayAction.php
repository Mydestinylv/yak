<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\PaySubAction;

class PayAction
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
     * 删除指定资源
     */
    public static function wechatPay($param,$customer_id)
    {
        $transfer = PaySubAction::wechatPay($param,$customer_id);
        if(!$transfer->status){
            return new Transfer('支付失败');
        }
        return new Transfer('', true, $transfer->data);
    }

}
