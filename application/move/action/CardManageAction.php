<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\CardManageSubAction;
use app\common\task\CardManageTask;

class CardManageAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        $where['customer_id'] = $customer_id;
        $field = 'id,card_name,total_price,expire_time,balance';
        $order = 'create_time desc';
        $transfer = CardManageTask::paginate($where,$field,$order);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        $data = to_array($transfer->data);
        return new Transfer('', true, $data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $transfer = CardManageTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->status);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $transfer = CardManageTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->status);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param,$customer_id)
    {
        $where['card_number'] = $param['card_number'];
        $where['secret_key'] = $param['secret_key'];
        $transfer = CardManageTask::valueByWhere($where,'id');
        if(!$transfer->status){
            return new Transfer('卡号不存在或密钥不存在');
        }
        if(!$transfer->data['id']){
            return new Transfer('卡号不存在或密钥不存在');
        }
        $where['id'] = $transfer->data['id'];
        unset($where['card_number']);
        $param['bind_time'] = date_now();
        $param['customer_id'] = $customer_id;
        $param['status'] = 2;
        $transfer = CardManageTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = CardManageTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->status);
    }

}
