<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\NoticeTask;

class NoticeSubAction
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
        if (isset($param['terminal']) && !empty($param['terminal'])) {
            $where['terminal'] = ['like', $param['terminal']];
        }
        if (isset($param['notice_status']) && !empty($param['notice_status'])) {
            $where['notice_status'] = ['like', $param['notice_status']];
        }
        $field = ['id,title,content,link,terminal,notice_status,create_time'];
        $order = 'create_time desc';
        $transfer = NoticeTask::paginate($where, $field, $order);
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
        $transfer = NoticeTask::save($param);
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
        $where['id'] = $param['id'];
        $field = ['id,title,content,link,terminal,notice_status,create_time'];
        $order = 'create_time desc';
        $transfer = NoticeTask::paginate($where, $field, $order);
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
        $transfer = NoticeTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = NoticeTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
