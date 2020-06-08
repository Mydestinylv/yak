<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\BookingManage;
use app\common\task\BookingManageTask;

class BookingManageSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$where = [])
    {
        if (isset($param['booking_tel']) && !empty($param['booking_tel'])) {
            $where['c.tel'] = ['like', '%' . $param['booking_tel'] . '%'];
        }
        if (isset($param['booking_name']) && !empty($param['booking_name'])) {
            $where['c.real_name'] = ['like', '%' . $param['booking_name'] . '%'];
        }
        $file = ['a.id,c.real_name as booking_name,c.tel as booking_tel,a.total_number,a.adult,a.children,a.attendance_time,a.submission_time,a.status,a.remarks,b.pasture_name'];
        $transfer = BookingManage::alias('a')
            ->join('Pasture b','a.pasture_id = b.id','LEFT')
            ->join('Customer c','a.customer_id = c.id','LEFT')
            ->where($where)
            ->field($file)
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
        $param['submission_time'] = date('Y-m-d H:i:s', time());
        $transfer = BookingManageTask::save($param);
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
        $table = 'Pasture b';
        $join_file = 'a.pasture_id = b.id';
        $file = ['a.id,a.booking_name,a.booking_tel,a.total_number,a.adult,a.children,a.attendance_time,a.submission_time,a.status,a.remarks,b.pasture_name'];
        $action = 'Left';
        $order = [];
        $transfer = BookingManageTask::join($table, $join_file, $action, $where, $file, $order,'find');
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
        $transfer = BookingManageTask::update($param, $where);
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
        $transfer = BookingManageTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true);
    }
}
