<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\SlaughterTask;

class SlaughterSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['yaks_name']) && !empty($param['yaks_name'])) {
            $where['c.yaks_name'] = ['like', '%' . $param['yaks_name'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['c.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['adoption_tel']) && !empty($param['adoption_tel'])) {
            $where['c.adoption_tel'] = ['like', '%' . $param['adoption_tel'] . '%'];
        }
        if (isset($param['status']) && !empty($param['status'])) {
            $where['a.status'] = $param['status'];
        }
        $table = ['SlaughterHouse b', 'Yaks c'];
        $join_file = ['a.slaughter_house_id = b.id', 'a.yaks_id = c.id'];
        $file = ['a.id,c.yaks_name,c.yaks_tag,b.slaughter_house_name,a.incoming_time,c.adoption_tel,a.status,a.update_time'];
        $action = ['Left', 'Left'];
        $order = [];
        $transfer = SlaughterTask::Mjoin($table, $join_file, $action, $where, $file, $order);
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
        $param['incoming_time'] = date_now();
        $param['completion_time'] = datetime_conversion($param['completion_time']);
        $transfer = SlaughterTask::save($param);
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
        if (isset($param['yaks_name']) && !empty($param['yaks_name'])) {
            $where['c.yaks_name'] = ['like', '%' . $param['yaks_name'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['c.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['adoption_tel']) && !empty($param['adoption_tel'])) {
            $where['c.adoption_tel'] = ['like', '%' . $param['adoption_tel'] . '%'];
        }
        if (isset($param['status']) && !empty($param['status'])) {
            $where['a.status'] = $param['status'];
        }
        $table = ['SlaughterHouse b', 'Yaks c'];
        $join_file = ['a.slaughter_house_id = b.id', 'a.yaks_id = c.id'];
        $file = ['a.id,c.yaks_name,c.yaks_tag,b.slaughter_house_name,a.incoming_time,c.adoption_tel,a.status,a.update_time'];
        $action = ['Left', 'Left'];
        $order = [];
        $transfer = SlaughterTask::Mjoin($table, $join_file, $action, $where, $file, $order,'find');
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
        $param['completion_time'] = datetime_conversion($param['completion_time']);
        $transfer = SlaughterTask::update($param,$where);
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
        $transfer = SlaughterTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 屠宰盒数管理
     */
    public static function slaughterBox($param)
    {
        $where = [];
        if (isset($param['yaks_name']) && !empty($param['yaks_name'])) {
            $where['c.yaks_name'] = ['like', '%' . $param['yaks_name'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['c.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['adoption_tel']) && !empty($param['adoption_tel'])) {
            $where['c.adoption_tel'] = ['like', '%' . $param['adoption_tel'] . '%'];
        }
        $table = ['SlaughterHouse b', 'Yaks c'];
        $join_file = ['a.slaughter_house_id = b.id', 'a.yaks_id = c.id'];
        $file = ['a.id,c.yaks_name,c.yaks_tag,b.slaughter_house_name,a.incoming_time,c.adoption_tel,a.final_box,a.completion_time'];
        $action = ['Left', 'Left'];
        $group = [];
        $transfer = SlaughterTask::Mjoin($table, $join_file, $action, $where, $file, $group);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
