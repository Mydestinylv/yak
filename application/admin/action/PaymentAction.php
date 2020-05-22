<?php

namespace app\admin\action;

use app\common\lib\Transfer;
use app\common\sub_action\PaymentSubAction;

class PaymentAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = PaymentSubAction::index($param);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $transfer = PaymentSubAction::save($param);
        if(!$transfer->status){
            return new Transfer('添加失败');
        }
        return new Transfer('', true, $transfer->data);
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
        $transfer = PaymentSubAction::update($param);
        if(!$transfer->status){
            return new Transfer('更新失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {

        return new Transfer('', true);
    }

}
