<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\CardManage;
use app\common\task\CardManageTask;

class CardManageSubAction
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
        if (isset($param['card_number']) && !empty($param['card_number'])) {
            $where['a.card_number'] = ['like', '%' . $param['card_number'] . '%'];
        }
        if (isset($param['real_name']) && !empty($param['real_name'])) {
            $where['b.real_name'] = ['like', '%' . $param['real_name'] . '%'];
        }
        if (isset($param['status']) && !empty($param['status'])) {
            $where['a.status'] = $param['status'];
        }
        $table = 'Customer b';
        $join_file = 'a.customer_id = b.id';
        $file = ['a.id,a.card_number,a.secret_key,a.status,a.balance,b.real_name,b.tel,a.bind_time,a.expire_time'];
        $action = 'Left';
        $order = 'a.create_time desc';
        $transfer = CardManageTask::join($table, $join_file, $action, $where, $file, $order);
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
        $param['bind_time'] = date('Y-m-d H:i:s', time());
        $param['expire_time'] = date('Y-m-d H:i:s', strtotime("+1 Year"));
        $transfer = CardManageTask::save($param);

        if (!$transfer->status) {
            return new Transfer('添加失败');
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
        $file = ['a.id,a.card_number,a.secret_key,a.status,a.balance,b.real_name,b.tel,a.bind_time,expire_time'];
        $action = 'Left';
        $group = [];
        $transfer = CardManageTask::join($table, $join_file, $action, $where, $file, $group);
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
        $transfer = CardManageTask::update($param,$where);
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
        $transfer = CardManageTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
