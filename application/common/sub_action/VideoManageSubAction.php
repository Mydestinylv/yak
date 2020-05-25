<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\VideoManageTask;

class VideoManageSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['title']) && !empty($param['title'])) {
            $where['title'] = ['like', '%' . $param['title'] . '%'];
        }
        $field = ['id,title,content,create_time'];
        $order = 'create_time desc';
        $transfer = VideoManageTask::paginate($where, $field, $order);
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
        $transfer = VideoManageTask::save($param);
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
        $field = ['id,title,content,create_time'];
        $order = 'create_time desc';
        $transfer = VideoManageTask::find($where, $field, $order);
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
        $where['id'] = $param['id'];
        unset($param['id']);
        $transfer = VideoManageTask::update($param, $where);
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
        $transfer = VideoManageTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
