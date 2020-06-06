<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\BookingManageSubAction;

class BookingManageAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        $where['customer_id'] = $customer_id;
        $transfer = BookingManageSubAction::index($param,$where);
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
        $transfer = BookingManageSubAction::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
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

        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {

        return new Transfer('', true);
    }

}
