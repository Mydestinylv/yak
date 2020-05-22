<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\RealNameAuth;
use app\common\task\RealNameAuthTask;

class RealNameAuthSubAction
{

    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['b.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['id_card']) && !empty($param['id_card'])) {
            $where['a.id_card'] = ['like', '%' . $param['id_card'] . '%'];
        }
        if (isset($param['real_name']) && !empty($param['real_name'])) {
            $where['b.real_name'] = ['like', '%' . $param['real_name'] . '%'];
        }
        if (isset($param['status']) && !empty($param['status'])) {
            $where['a.status'] = $param['status'];
        }
        $table = 'Customer b';
        $join_file = 'a.customer_id = b.id';
        $file = ['a.id,a.id_card,a.positive,a.back,a.auth_time,b.real_name,b.tel,a.status'];
        $action = 'Left';
        $order = 'a.create_time desc';
        $transfer = RealNameAuthTask::join($table, $join_file, $action, $where, $file, $order);
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
        $param['positive'] = img_upload($param['positive']);
        $param['back'] = img_upload($param['back']);
        $param['auth_time'] = date('Y-m-d H:i:s', time());
        $transfer = RealNameAuthTask::save($param);
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
        $where['a.id'] = $param['id'];
        $table = 'Customer b';
        $join_file = 'a.customer_id = b.id';
        $file = ['a.id,a.id_card,a.positive,a.back,a.auth_time,b.real_name,b.tel,a.status'];
        $action = 'Left';
        $group = [];
        $transfer = RealNameAuthTask::join($table, $join_file, $action, $where, $file, $group);
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
        $where['id'] = $param['id'];
        unset($param['id']);
        $transfer = RealNameAuthTask::update($param,$where);
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
        $transfer = RealNameAuthTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('保存失败');
        }
        return new Transfer('', true);
    }
}
