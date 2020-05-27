<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\FoodCustomizedSubAction;
use app\common\task\FoodCustomizedTask;

class FoodCustomizedAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        $where['customer_id'] = $customer_id;
        $field = 'id,feedback_status,create_time';
        $transfer = FoodCustomizedTask::paginate($where,$field);
        if(!$transfer->status){
            return new Transfer($transfer->message);
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param,$customer_id)
    {
        $transfer = FoodCustomizedSubAction::save($param,$customer_id);
        if(!$transfer->status){
            return new Transfer($transfer->message);
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $field = ['id,apply_name,apply_tel,family_number,beneficiary,note,menu_type,menu_number,create_time,feedback_content,feedback_picture,feedback_video'];
        $transfer = FoodCustomizedSubAction::read($param,$field);
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
