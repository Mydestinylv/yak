<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\HelpfulProjectTask;

class HelpfulProjectSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['helpful_project_status']) && !empty($param['helpful_project_status'])) {
            $where['helpful_project_status'] = ['like', '%' . $param['helpful_project_status'] . '%'];
        }
        if (isset($param['project_title']) && !empty($param['project_title'])) {
            $where['project_title'] = ['like', '%' . $param['project_title'] . '%'];
        }
        $field = ['id,project_title,project_content,project_cover,helpful_project_status,create_time,help_join,help_number,help_money'];
        $transfer = HelpfulProjectTask::paginate($where,$field);
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
        $transfer = HelpfulProjectTask::save($param);
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        return new Transfer('', true,$transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $where['id'] = $param['id'];
        $field = ['project_title,project_content,project_cover,helpful_project_status,create_time,help_join,help_number,help_money'];
        $transfer = HelpfulProjectTask::select($where,$field);
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
        $transfer = HelpfulProjectTask::update($param,$where);
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
        $transfer = HelpfulProjectTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
