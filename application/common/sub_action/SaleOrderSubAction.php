<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\LogisticsOrder;
use app\common\model\SaleOrder;
use app\common\task\LogisticsOrderTask;
use app\common\task\ReceivingAddressTask;
use app\common\task\SaleOrderTask;
use think\Env;

class SaleOrderSubAction
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
            $where['b.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['logistics_code']) && !empty($param['logistics_code'])) {
            $where['d.logistics_code'] = ['like', '%' . $param['logistics_code'] . '%'];
        }
        $table = ['Customer b','Yaks c','LogisticsOrder d'];
        $join_file = ['a.customer_id = b.id','a.yaks_id = c.id','a.order_code = d.sale_order_code'];
        $file = ['a.id,a.order_code,a.goods,a.goods_number,a.real_price,a.pay_type,a.pay_time,a.pay_status,b.tel,b.real_name,
        c.yaks_name,c.yaks_tag,d.logistics_address,d.logistics_company,d.logistics_code,d.logistics_status,d.receiving_time'];
        $action = ['Left','Left','Left'];
        $order = [];
        $transfer = SaleOrderTask::Mjoin($table,$join_file,$action,$where,$file,$order);
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
            $where['b.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['logistics_code']) && !empty($param['logistics_code'])) {
            $where['d.logistics_code'] = ['like', '%' . $param['logistics_code'] . '%'];
        }
        $table = ['Customer b','Yaks c','LogisticsOrder d'];
        $join_file = ['a.customer_id = b.id','a.yaks_id = c.id','a.order_code = d.sale_order_code'];
        $file = ['a.id,a.order_code,a.goods,a.goods_number,a.real_price,a.pay_type,a.pay_time,a.pay_status,b.tel,b.real_name,
        c.yaks_name,c.yaks_tag,d.logistics_address,d.logistics_company,d.logistics_code,d.logistics_status,d.receiving_time'];
        $action = ['Left','Left','Left'];
        $order = [];
        $transfer = SaleOrderTask::Mjoin($table,$join_file,$action,$where,$file,$order,'find');
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param,$customer_id)
    {
        if(isset($param['receiving_address_id'])&&!empty($param['receiving_address_id'])){
            $where['id'] = $param['receiving_address_id'];
            unset($param['receiving_address_id']);
            $where['customer_id'] = $customer_id;
            $transfer = ReceivingAddressTask::find($where,'consignee_add');
            if(!$transfer->status){
                return new Transfer('保存失败');
            }
            if($transfer->data['consignee_add']){
                $consignee_add = substr($transfer->data['consignee_add'],0,2);
                if($consignee_add!='四川'||$consignee_add!='重庆'){
                    $param['postage'] = Env::get('postage') * $param['goods_number'];
                }else{
                    $param['postage'] = 0;
                }
            }
        }else{
            return new Transfer('请选择地址');
        }
        $param['goods_unit_price'] = Env::get('goods_unit_price');
        if(isset($param['sale_type'])&&!empty($param['sale_type'])){
            switch ($param['sale_type']){
                case SaleOrder::SELF:
                    $param['goods_total_price'] = $param['process_cost']+$param['postage'];
                    $param['real_price'] = $param['goods_total_price'];
                    break;
                case SaleOrder::GIFT:
                    $param['goods_total_price'] = $param['postage'];
                    $param['real_price'] = $param['goods_total_price'];
                    break;
                case SaleOrder::SALE:
                    $param['goods_total_price'] = $param['postage'] + ($param['goods_unit_price']*$param['goods_number']);
                    $param['real_price'] = $param['goods_total_price'];
                    break;
                default:
                    return new Transfer('保存失败');
            }
        }
//        $param['pay_time'] = date_now();
        $order_code = getOrderCode();
        $param['order_code'] = $order_code->data['order_code'];
        $param['pay_status'] = 0;
        $param['customer_id'] = $customer_id;
        $transfer = SaleOrderTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
