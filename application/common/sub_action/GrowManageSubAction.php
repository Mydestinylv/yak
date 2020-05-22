<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\GrowManageTask;
use app\common\task\TaskManageTask;

class GrowManageSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['yaks_name']) && !empty($param['yaks_name'])) {
            $where['b.yaks_name'] = ['like', '%' . $param['yaks_name'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['b.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['adoption_tel']) && !empty($param['adoption_tel'])) {
            $where['b.adoption_tel'] = ['like', '%' . $param['adoption_tel'] . '%'];
        }
        if (isset($param['herdsman_name']) && !empty($param['herdsman_name'])) {
            $where['c.name'] = ['like', '%' . $param['herdsman_name'] . '%'];
        }
        $table = ['Yaks b','Herdsman c'];
        $join_file = ['a.pasture_id = b.pasture_id','b.herdsman_id = c.id'];
        $file = ['a.id,a.task_name,a.task_detail,a.enclosure_url,a.finish_time,b.yaks_name,c.name as herdsman_name,b.adoption_tel,b.yaks_tag'];
        $action = ['Left','Left'];
        $group = [];
        $transfer = TaskManageTask::Mjoin($table,$join_file,$action,$where,$file,$group);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
