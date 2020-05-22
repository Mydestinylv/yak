<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\MenuTask;

class MenuSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['menu_title']) && !empty($param['menu_title'])) {
            $where['menu_title'] = ['like', '%' . $param['menu_title'] . '%'];
        }
        if (isset($param['menu_type']) && !empty($param['menu_type'])) {
            $where['menu_type'] = ['like', '%' . $param['menu_type'] . '%'];
        }
        $field = ['id,menu_title,menu_cover,menu_type,menu_content,menu_picture,menu_video,create_time'];
        $order = ['create_time desc'];
        $transfer = MenuTask::paginate($where,$field,$order);
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
        $param['menu_cover'] = img_upload($param['menu_cover']);
        $param['menu_picture'] = img_upload($param['menu_picture']);
        $param['menu_video'] = img_upload($param['menu_video']);
        $transfer = MenuTask::save($param);
        if(!$transfer->status){
            return new Transfer('添加失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $where['id'] = $param['id'];
        $field = ['id,menu_title,menu_cover,menu_type,menu_content,menu_picture,menu_video,create_time'];
        $order = ['create_time desc'];
        $transfer = MenuTask::find($where,$field,$order);
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
        $param['menu_cover'] = img_upload($param['menu_cover']);
        $param['menu_picture'] = img_upload($param['menu_picture']);
        $param['menu_video'] = img_upload($param['menu_video']);
        $transfer = MenuTask::update($param,$where);
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
        $transfer = MenuTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
