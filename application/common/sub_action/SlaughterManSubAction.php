<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\SlaughterManTask;

class SlaughterManSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['a.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['name']) && !empty($param['name'])) {
            $where['a.name'] = ['like', '%' . $param['name'] . '%'];
        }
        if (isset($param['id_card']) && !empty($param['id_card'])) {
            $where['a.id_card'] = ['like', '%' . $param['id_card'] . '%'];
        }
        $field = ['a.id','a.name','a.head_img','a.tel','a.id_card','a.total_balance','a.freezing_balance',
            'a.positive','a.back','a.score','a.introduce','a.healthy','a.create_time','b.slaughter_house_name,a.prove'];
        $table = 'SlaughterHouse b';
        $join_field = 'a.slaughter_house_id = b.id';
        $action = 'Left';
        $order = 'a.create_time';
        $transfer = SlaughterManTask::join($table,$join_field,$action,$where,$field,$order);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $transfer = SlaughterManTask::save($param);
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
        $where['a.id'] = $param['id'];
        $field = ['a.id','a.name','a.head_img','a.tel','a.id_card','a.total_balance','a.freezing_balance',
            'a.positive','a.back','a.score','a.introduce','a.healthy','a.create_time','b.slaughter_house_name,a.prove'];
        $table = 'SlaughterHouse b';
        $join_field = 'a.slaughter_house_id = b.id';
        $action = 'Left';
        $order = 'a.create_time';
        $transfer = SlaughterManTask::join($table,$join_field,$action,$where,$field,$order,'','find');
        if(!$transfer->status){
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
        $transfer = SlaughterManTask::update($param,$where);
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
        $transfer = SlaughterManTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function password_reset($param)
    {
        $where['id'] = $param['id'];
        unset($param['id']);
        $transfer = SlaughterManTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('重置失败');
        }
        return new Transfer('', true);
    }
}
