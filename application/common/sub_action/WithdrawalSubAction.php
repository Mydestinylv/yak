<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\WithdrawalTask;

class WithdrawalSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['withdrawal_account']) && !empty($param['withdrawal_account'])) {
            $where['withdrawal_account'] = ['like', '%' . $param['withdrawal_account'] . '%'];
        }
        $file = 'id,user_type,withdrawal_price,service_charge,account_price,withdrawal_account,withdrawal_status,
        withdrawal_remark,create_time,name,tel';
        $group = ['create_time desc'];
        $transfer = WithdrawalTask::paginate($where,$file,$group);
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
        $transfer = WithdrawalTask::save($param);
        if(!$transfer->status){
            return new Transfer('提现失败');
        }
        return new Transfer('', true,$transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function bill($param,$type)
    {
        $where['withdrawal_id'] = $param['id'];
        $where['user_type'] = $type;
        $field = 'id,withdrawal_price,create_time,service_charge';
        $transfer = WithdrawalTask::paginate($where,$field,'create_time desc');
        if(!$transfer->status){
            return new Transfer('获取账单失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $where['id'] = $param['id'];
        $transfer = WithdrawalTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('更新失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {

        return new Transfer('', true);
    }
}
