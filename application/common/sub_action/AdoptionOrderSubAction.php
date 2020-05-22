<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\AdoptionOrderTask;

class AdoptionOrderSubAction
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
        if (isset($param['customer_tel']) && !empty($param['customer_tel'])) {
            $where['a.customer_tel'] = ['like', '%' . $param['customer_tel'] . '%'];
        }
        if (isset($param['pay_type']) && !empty($param['pay_type'])) {
            $where['a.pay_type'] = $param['pay_type'];
        }
        $table = 'Yaks b';
        $join_file = 'a.yaks_id = b.id';
        $file = ['a.id,a.order_number,a.customer_tel,a.customer_real_name,a.pay_type,a.pay_money,a.pay_time,a.pay_status,b.yaks_name,b.yaks_tag'];
        $action = 'Left';
        $group = [];
        $transfer = AdoptionOrderTask::join($table,$join_file,$action,$where,$file,$group);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
