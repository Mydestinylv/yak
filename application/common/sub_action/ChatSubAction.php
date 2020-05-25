<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\Chat;
use app\common\task\ChatTask;

class ChatSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$where = [])
    {
        $field = 'id,customer_id as customer_name,herdsman_id as herdsman_name,slaughter_man_id as slaughter_man_name,type,content,create_time';
        $order = 'create_time desc';
        $transfer = ChatTask::paginate($where,$field,$order);
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
        $transfer = ChatTask::save($param);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }
}
