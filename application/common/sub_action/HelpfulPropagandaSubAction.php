<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\HelpfulPropagandaTask;

class HelpfulPropagandaSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        $order = ['create_time desc'];
        $field = ['id,link,cover,propaganda_status,create_time'];
        $transfer = HelpfulPropagandaTask::paginate($where,$field,$order);
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
        $param['cover'] = img_upload($param['cover']);
        $transfer = HelpfulPropagandaTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $where = [];
        $order = ['create_time desc'];
        $field = ['id,link,cover,propaganda_status,create_time'];
        $transfer = HelpfulPropagandaTask::find($where,$field,$order);
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
        unset($param['id']);
        $param['cover'] = img_upload($param['cover']);
        $transfer = HelpfulPropagandaTask::update($param,$where);
        if(!$transfer->status){
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = HelpfulPropagandaTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
