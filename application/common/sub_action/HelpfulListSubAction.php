<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\HelpfulListTask;

class HelpfulListSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['project_title']) && !empty($param['project_title'])) {
            $where['c.project_title'] = ['like', '%' . $param['project_title'] . '%'];
        }
        if (isset($param['real_name']) && !empty($param['real_name'])) {
            $where['b.real_name'] = ['like', '%' . $param['real_name'] . '%'];
        }
        $table = ['Customer b','HelpfulProject c'];
        $join_file = ['a.customer_id = b.id','a.helpful_project_id = c.id'];
        $action = ['Left','Left'];
        $field = ['a.id,a.helpful_price,a.create_time,b.real_name,b.head_img,b.tel,c.project_title'];
        $transfer = HelpfulListTask::Mjoin($table,$join_file,$action,$where,$field);
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
        $transfer = HelpfulListTask::save($param);
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
        $where['a.id'] = $param['id'];
        $table = ['Customer b','HelpfulProject c'];
        $join_file = ['a.customer_id = b.id','a.helpful_project_id = c.id'];
        $action = ['Left','Left'];
        $field = ['a.id,a.helpful_price,a.create_time,b.real_name,b.head_img,b.tel,c.project_title'];
        $transfer = HelpfulListTask::Mjoin($table,$join_file,$action,$where,$field,'','find');
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
        $transfer = HelpfulListTask::update($param,$where);
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
        $transfer = HelpfulListTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
