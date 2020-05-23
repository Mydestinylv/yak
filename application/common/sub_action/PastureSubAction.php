<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\PastureTask;

class PastureSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['pasture_name']) && !empty($param['pasture_name'])) {
            $where['pasture_name'] = ['like', '%' . $param['pasture_name'] . '%'];
        }
        $field = ['id,pasture_name,pasture_address,cover,introduce,pasture_tel'];
        $transfer = PastureTask::paginate($where,$field);
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $transfer = PastureTask::valueByWhere(['pasture_name'=>$param['pasture_name']],'id');
        if(!$transfer->status){
            return new Transfer('保存失败');
        }elseif($transfer->data['id']){
            return new Transfer('牧场名称已存在');
        }
        $transfer = PastureTask::save($param);
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
        unset($param['id']);
        $field = ['id,pasture_name,pasture_address,cover,introduce,pasture_tel'];
        $transfer = PastureTask::find($where,$field);
        if ($transfer === false) {
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
        $transfer = PastureTask::update($param,$where);
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
        $transfer = PastureTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
