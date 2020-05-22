<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\FeedbackTask;

class FeedbackSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['description']) && !empty($param['description'])) {
            $where['description'] = ['like', '%' . $param['description'] . '%'];
        }
        if (isset($param['real_name']) && !empty($param['real_name'])) {
            $where['real_name'] = ['like', '%' . $param['real_name'] . '%'];
        }
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['customer_type']) && !empty($param['customer_type'])) {
            $where['customer_type'] = ['like',$param['customer_type']];
        }
        if (isset($param['feedback_status']) && !empty($param['feedback_status'])) {
            $where['feedback_status'] = ['like',$param['feedback_status']];
        }
        $filed = 'id,description,enclosure,feedback_status,create_time,name,tel,user_type';
        $order = 'create_time desc';
        $transfer = FeedbackTask::paginate( $where, $filed, $order);
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
        $transfer = FeedbackTask::save($param);
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
        $filed = 'id,description,enclosure,feedback_status,create_time,name,tel,user_type';
        $order = 'create_time desc';
        $transfer = FeedbackTask::find($where, $filed, $order);
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
        $transfer = FeedbackTask::update($param,$where);
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
        $transfer = FeedbackTask::delete($param);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
