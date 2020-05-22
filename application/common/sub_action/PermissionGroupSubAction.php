<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\PermissionGroupTask;

class PermissionGroupSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        $transfer = PermissionGroupTask::paginate($where);
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
        $transfer = PermissionGroupTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
