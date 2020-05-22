<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\ReceivingAddressTask;

class ReceivingAddressSubAction
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
        if (isset($param['consignee_name']) && !empty($param['consignee_name'])) {
            $where['a.consignee_name'] = ['like', '%' . $param['consignee_name'] . '%'];
        }
        if (isset($param['consignee_tel']) && !empty($param['consignee_tel'])) {
            $where['a.consignee_tel'] = ['like', '%' . $param['consignee_tel'] . '%'];
        }
        $table = 'Customer b';
        $join_file = 'a.customer_id = b.id';
        $file = ['a.id,a.consignee_name,a.consignee_tel,a.consignee_add,a.is_default,b.tel,a.create_time'];
        $action = 'Left';
        $order = [];
        $transfer = ReceivingAddressTask::join($table, $join_file, $action, $where, $file, $order);
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
        $transfer = ReceivingAddressTask::save($param);
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
        $file = ['a.id,a.consignee_name,a.consignee_tel,a.consignee_add,a.is_default,b.tel,a.create_time'];
        $action = 'Left';
        $order = [];
        $transfer = ReceivingAddressTask::join($table, $join_file, $action, $where, $file, $order,'','find');
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
        $transfer = ReceivingAddressTask::update($param,$where);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = ReceivingAddressTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
