<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\HerdsmanTask;

class HerdsmanSubAction
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
            'a.positive','a.back','a.score','a.introduce','a.healthy','a.create_time','count(c.id) as yaks_num','b.pasture_name'];
        $table = ['Pasture b','Yaks c'];
        $join_field = ['a.pasture_id = b.id','a.id = c.herdsman_id'];
        $action = ['Left','Left'];
        $order = 'a.create_time';
        $group = 'a.id';
        $transfer = HerdsmanTask::join($table,$join_field,$action,$where,$field,$order,$group);
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
        $param['head_img'] = img_upload($param['head_img']);
        if(isset($param['positive'])&&!empty($param['positive'])){
            $param['positive'] = img_upload($param['positive']);
        }
        if(isset($param['back'])&&!empty($param['back'])){
            $param['back'] = img_upload($param['back']);
        }
        if(isset($param['healthy'])&&!empty($param['healthy'])){
            $param['healthy'] = img_upload($param['healthy']);
        }
        $transfer = HerdsmanTask::save($param);
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
            'a.positive','a.back','a.score','a.introduce','a.healthy','a.create_time','count(c.id) as yaks_num','b.pasture_name'];
        $table = ['Pasture b','Yaks c'];
        $join_field = ['a.pasture_id = b.id','a.id = c.herdsman_id'];
        $action = ['Left','Left'];
        $order = 'a.create_time';
        $group = 'a.id';
        $transfer = HerdsmanTask::join($table,$join_field,$action,$where,$field,$order,$group,'find');
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
        $param['head_img'] = img_upload($param['head_img']);
        if(isset($param['positive'])&&!empty($param['positive'])){
            $param['positive'] = img_upload($param['positive']);
        }
        if(isset($param['back'])&&!empty($param['back'])){
            $param['back'] = img_upload($param['back']);
        }
        if(isset($param['healthy'])&&!empty($param['healthy'])){
            $param['healthy'] = img_upload($param['healthy']);
        }
        $transfer = HerdsmanTask::update($param,$where);
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
        $transfer = HerdsmanTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 保存更新的资源
     */
    public static function password_reset($param)
    {
        $where['id'] = $param['id'];
        $transfer = HerdsmanTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('重置失败');
        }
        return new Transfer('', true);
    }
}
