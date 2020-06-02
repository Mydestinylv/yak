<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\Yaks;
use app\common\task\YaksTask;

class YaksSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$where = [])
    {
        if (isset($param['yaks_name']) && !empty($param['yaks_name'])) {
            $where['a.yaks_name'] = ['like', '%' . $param['yaks_name'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['a.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['yaks_sex']) && !empty($param['yaks_sex'])) {
            $where['a.yaks_sex'] = $param['yaks_sex'];
        }
        if (isset($param['adoption_tel']) && !empty($param['adoption_tel'])) {
            $where['a.adoption_tel'] = ['like', '%' . $param['adoption_tel'] . '%'];
        }
        if (isset($param['is_adoption']) && !empty($param['is_adoption'])) {
            $where['a.is_adoption'] = $param['is_adoption'];
        }
        if (isset($param['herdsman_name']) && !empty($param['herdsman_name'])) {
            $where['c.herdsman_name'] = ['like', '%' . $param['herdsman_name'] . '%'];
        }
        $table = ['Pasture b','Herdsman c'];
        $join_file = ['a.pasture_id = b.id','a.pasture_id = c.id'];
        $file = ['a.id,a.yaks_name,a.yaks_img,a.yaks_tag,a.yaks_birthday,a.yaks_sex,b.pasture_name,a.adoption_tel,a.adoption_time,c.name as herdsman_name,c.tel as herdsman_tel,a.is_adoption,a.remarks'];
        $action = ['Left','Left'];
        $group = [];
        $transfer = YaksTask:: Mjoin($table,$join_file,$action,$where,$file,$group);
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
        $transfer = YaksTask::valueByWhere(['yaks_tag'=>$param['yaks_tag']],'id');
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        if($transfer->data['id']){
            return new Transfer('耳标号已存在');
        }
        $transfer = YaksTask::save($param);
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
        $table = ['Pasture b','Herdsman c'];
        $join_file = ['a.pasture_id = b.id','a.pasture_id = c.id'];
        $file = ['a.id,a.yaks_name,a.yaks_img,a.yaks_tag,a.yaks_birthday,a.yaks_sex,b.pasture_name,a.adoption_tel,a.adoption_time,c.name as herdsman_name,c.tel as herdsman_tel,a.is_adoption,a.remarks'];
        $action = ['Left','Left'];
        $order = [];
        $transfer = YaksTask:: Mjoin($table,$join_file,$action,$where,$file,$order,'find');
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
        $transfer = YaksTask::update($param,$where);
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
        $transfer = YaksTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
