<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\LogisticsOrder;
use app\common\task\LogisticsOrderTask;

class LogisticsOrderSubAction
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
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['d.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['logistics_code']) && !empty($param['logistics_code'])) {
            $where['a.logistics_code'] = ['like', '%' . $param['logistics_code'] . '%'];
        }
        $table = ['SaleOrder b','Yaks c','Customer d'];
        $join_file = ['a.sale_order_code = b.order_code','b.yaks_id = c.id','b.customer_id = d.id'];
        $file = ['a.id,b.order_code,b.goods,b.goods_number,b.real_price,b.pay_type,b.pay_time,b.pay_status,d.tel,d.real_name,
        c.yaks_name,c.yaks_tag,a.logistics_address,a.logistics_company,a.logistics_code,a.logistics_status,a.receiving_time'];
        $action = ['Left','Left','Left'];
        $order = [];
        $transfer = LogisticsOrderTask::Mjoin($table,$join_file,$action,$where,$file,$order);
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
        $transfer = LogisticsOrderTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }
    /**
     * 显示资源列表
     */
    public static function read($param)
    {
        $where = [];
        if (isset($param['yaks_name']) && !empty($param['yaks_name'])) {
            $where['c.yaks_name'] = ['like', '%' . $param['yaks_name'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['c.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['d.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['logistics_code']) && !empty($param['logistics_code'])) {
            $where['a.logistics_code'] = ['like', '%' . $param['logistics_code'] . '%'];
        }
        $table = ['SaleOrder b','Yaks c','Customer d'];
        $join_file = ['a.sale_order_code = b.order_code','b.yaks_id = c.id','b.customer_id = d.id'];
        $file = ['a.id,b.order_code,b.goods,b.goods_number,b.real_price,b.pay_type,b.pay_time,b.pay_status,d.tel,d.real_name,
        c.yaks_name,c.yaks_tag,a.logistics_address,a.logistics_company,a.logistics_code,a.logistics_status,a.receiving_time'];
        $action = ['Left','Left','Left'];
        $order = [];
        $transfer = LogisticsOrderTask::Mjoin($table,$join_file,$action,$where,$file,$order,'find');
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
