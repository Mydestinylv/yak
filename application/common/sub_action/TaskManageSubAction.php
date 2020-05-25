<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\TaskManage;
use app\common\task\TaskManageTask;

class TaskManageSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        $field = ['a.id,b.pasture_name,a.task_name,a.task_detail,a.enclosure_url,a.finish_time,a.create_time,a.order'];
        $transfer = TaskManage::alias('a')
            ->join('Pasture b', 'a.pasture_id = b.id', 'LEFT')
            ->field($field)
            ->paginate();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, to_array($transfer));
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $where['pasture_id'] = $param['pasture_id'];
        $transfer = TaskManageTask::find($where, 'order','create_time desc');
        if (!$transfer->status) {
            return new Transfer('添加失败');
        }
        if (!$transfer->data['order']) {
            $param['order'] = 1;
        } else {
            $param['order'] = $transfer->data['order'] + 1;
        }
        $param['finish_time'] = datetime_conversion($param['finish_time']);
        $transfer = TaskManageTask::save($param);
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
        $where['id'] = $param['id'];
        $field = ['a.id,b.pasture_name,a.task_name,a.task_detail,a.enclosure_url,a.finish_time,a.create_time,a.order'];
        $transfer = TaskManage::alias('a')
            ->join('Pasture b', 'a.pasture_id = b.id', 'LEFT')
            ->field($field)
            ->find();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, to_array($transfer));
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $where['id'] = $param['id'];
        unset($param['id']);
        $transfer = TaskManageTask::update($param, $where);
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
        $transfer = TaskManageTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
