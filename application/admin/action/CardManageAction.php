<?php

namespace app\admin\action;

use app\common\lib\Transfer;
use app\common\sub_action\CardManageSubAction;

class CardManageAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = CardManageSubAction::index($param);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $transfer = CardManageSubAction::save($param);
        if (!$transfer->status) {
            return new Transfer($transfer->message);
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $transfer = CardManageSubAction::read($param);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $transfer = CardManageSubAction::update($param);
        if (!$transfer->status) {
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = CardManageSubAction::delete($param);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

}
