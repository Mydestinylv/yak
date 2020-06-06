<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\AdoptionOrder;
use app\common\task\AdoptionOrderTask;
use app\common\task\CustomerTask;
use app\common\task\FoodCustomizedTask;

class FoodCustomizedSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['apply_tel']) && !empty($param['apply_tel'])) {
            $where['apply_tel'] = ['like', '%' . $param['apply_tel'] . '%'];
        }
        if (isset($param['apply_name']) && !empty($param['apply_name'])) {
            $where['apply_name'] = ['like', '%' . $param['apply_name'] . '%'];
        }
        if (isset($param['menu_type']) && !empty($param['menu_type'])) {
            $where['menu_type'] = ['like', $param['menu_type']];
        }
        $field = ['id,apply_name,apply_tel,family_number,beneficiary,note,menu_type,menu_number,create_time'];
        $order = 'create_time desc';
        $transfer = FoodCustomizedTask::paginate($where, $field, $order);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param,$customer_id)
    {
        $where['customer_id'] = $customer_id;
        $where['pay_status'] = 1;
        $transfer = AdoptionOrderTask::count($where);
        if(!$transfer->status){
            return new Transfer('新增失败');
        }
        $yaks_count = $transfer->data['count'];
        unset($where['pay_status']);
        $transfer = FoodCustomizedTask::count($where);
        if(!$transfer->status){
            return new Transfer('新增失败');
        }
        $food_customized_count = $transfer->data['count'];
        if($yaks_count<=$food_customized_count){
            return new Transfer('超过定制菜品数量，你当前剩余申请道数为'.($food_customized_count-$yaks_count).'道');
        }
        $transfer = CustomerTask::find(['id'=>$customer_id],'real_name,tel');
        if(!$transfer->status){
            return new Transfer('新增失败');
        }
        $param['apply_name'] = $transfer->data['real_name'];
        $param['apply_tel'] = $transfer->data['tel'];
        $param['customer_id'] = $customer_id;
        $transfer = FoodCustomizedTask::save($param);
        if (!$transfer->status) {
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param,$field)
    {
        $where['id'] = $param['id'];
        $order = 'create_time desc';
        $transfer = FoodCustomizedTask::find($where, $field, $order);
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
        $transfer = FoodCustomizedTask::update($param,$where);
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
        $transfer = FoodCustomizedTask::delete($param['id']);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 保存更新的资源
     */
    public static function feedback($param)
    {
        $param['feedback_status'] = 2;
        $where['id'] = $param['id'];
        unset($param['id']);
        $transfer = FoodCustomizedTask::update($param,$where);
        if (!$transfer->status) {
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }
}
