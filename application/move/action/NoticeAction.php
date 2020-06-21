<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\Notice;
use app\common\sub_action\NoticeSubAction;
use app\common\task\NoticeTask;

class NoticeAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$type)
    {
        switch ($type){
            case 1:
                $where['terminal'] = 1;
                break;
            case 2:
                $where['terminal'] = 2;
                break;
            case 3:
                $where['terminal'] = 3;
                break;
            default:
                return new Transfer('查询失败');
        }
        $where['notice_status'] = 1;
        $transfer = NoticeSubAction::index($param,$where);
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

        return new Transfer('', true);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $where['id'] = $param['id'];
        $where['notice_status'] = 1;
        $transfer = NoticeTask::find($where,'id,title,content,notice_status,create_time,link');
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
