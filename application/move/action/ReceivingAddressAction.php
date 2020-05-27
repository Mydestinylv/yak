<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\ReceivingAddress;
use app\common\sub_action\ReceivingAddressSubAction;
use app\common\task\ReceivingAddressTask;
use think\Db;

class ReceivingAddressAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        $where['customer_id'] = $customer_id;
        $field = 'id,consignee_name,consignee_tel,consignee_add,is_default';
        $transfer = ReceivingAddressTask::paginate($where,$field);
        if(!$transfer->status){
            return New Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param,$customer_id)
    {
        Db::startTrans();
        $where['customer_id'] = $customer_id;
        if($param['is_default'] == 1){
            $data['is_default'] = 0;
            $transfer = ReceivingAddressTask::update($data,$where);
            if(!$transfer->status){
                Db::rollback();
                return new Transfer('新增失败');
            }
        }
        $param['customer_id'] = $customer_id;
        $transfer = ReceivingAddressTask::save($param);
        if(!$transfer->status){
            Db::rollback();
            return New Transfer('新增失败');
        }
        Db::commit();
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {

        return new Transfer('', true);
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
