<?php

namespace app\admin\action;

use app\common\lib\Transfer;
use app\common\sub_action\CustomerSubAction;

class CustomerAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = CustomerSubAction::index($param);
        if (!$transfer->status) {
            return new Transfer('查询错误');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     *
     */
    public static function save($param)
    {
        $transfer = CustomerSubAction::save($param);
        if (!$transfer->status) {
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $transfer = CustomerSubAction::read($param);
        if (!$transfer->status) {
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $transfer = CustomerSubAction::update($param);
        if (!$transfer->status) {
            return new Transfer('保存失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = CustomerSubAction::delete($param);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function password_reset($param)
    {
        $transfer = CustomerSubAction::password_reset($param);
        if (!$transfer->status) {
            return new Transfer('重置失败');
        }
        return new Transfer('', true);
    }

}
