<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\Customer;
use app\common\sub_action\CustomerSubAction;
use app\common\sub_action\WithdrawalSubAction;
use app\common\task\CustomerTask;
use app\common\task\HerdsmanTask;
use app\common\task\SlaughterManTask;
use app\common\task\WithdrawalTask;
use think\Db;
use think\Env;

class WithdrawalAction
{
    /**
     * 显示资源列表
     */
    public static function index($param, $where, $type)
    {
        switch ($type) {
            case 1 :
                $transfer = CustomerTask::find($where, 'id,total_balance,freezing_balance,real_name as name,id_card');
                break;
            case 2 :
                $transfer = HerdsmanTask::find($where, 'id,total_balance,freezing_balance,name,id_card');
                break;
            case 3 :
                $transfer = SlaughterManTask::find($where, 'id,total_balance,freezing_balance,name,id_card');
                break;
            default :
                return new Transfer('获取资源失败');
        }
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, to_array($transfer->data));
    }

    /**
     * 保存新建的资源
     */
    public static function save($param, $type)
    {
        Db::startTrans();
        $param['service_charge'] = $param['withdrawal_price'] * Env::get('service_charge');
        $param['account_price'] = $param['withdrawal_price'] - $param['service_charge'];
        $param['user_type'] = $type;
        $param['withdrawal_status'] = 1;
        $where['id'] = $param['id'];
        $param['withdrawal_id'] = $param['id'];
        unset($param['id']);
        $transfer = WithdrawalSubAction::save($param);
        if (!$transfer->status) {
            return new Transfer('提现失败');
        }
        $return_data = $transfer->data;
        switch ($type) {
            case 1 :
                $transfer = CustomerTask::find($where, 'total_balance,freezing_balance');
                if (!$transfer->status) {
                    Db::rollback();
                    return new Transfer('提现失败');
                }
                $data['total_balance'] = ($transfer->data['total_balance'] - $transfer->data['freezing_balance']) - $param['withdrawal_price'];
                if ($data['total_balance'] < 0) {
                    Db::rollback();
                    return new Transfer('超过提现金额');
                }
                $transfer = CustomerTask::update($data, $where);
                break;
            case 2 :
                $transfer = HerdsmanTask::find($where, 'total_balance,freezing_balance');
                if (!$transfer->status) {
                    Db::rollback();
                    return new Transfer('提现失败');
                }
                $data['total_balance'] = ($transfer->data['total_balance'] - $transfer->data['freezing_balance']) - $param['withdrawal_price'];
                if ($data['total_balance'] < 0) {
                    Db::rollback();
                    return new Transfer('超过提现金额');
                }
                $transfer = HerdsmanTask::update($data, $where);
                break;
            case 3 :
                $transfer = SlaughterManTask::find($where, 'total_balance,freezing_balance');
                if (!$transfer->status) {
                    Db::rollback();

                    return new Transfer('提现失败');
                }
                $data['total_balance'] = ($transfer->data['total_balance'] - $transfer->data['freezing_balance']) - $param['withdrawal_price'];
                if ($data['total_balance'] < 0) {
                    Db::rollback();
                    return new Transfer('超过提现金额');
                }
                $transfer = SlaughterManTask::update($data, $where);
                break;
            default :
                return format('获取资源失败');
        }
        if (!$transfer->status) {
            Db::rollback();
            return new Transfer('查询失败');
        }
        Db::commit();
        return new Transfer('', true, $return_data);
    }

    /**
     * 显示指定的资源
     */
    public static function bill($param,$type)
    {
        $transfer = WithdrawalSubAction::bill($param,$type);
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

        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {

        return new Transfer('', true);
    }

}
