<?php

namespace app\admin\action;

use app\common\lib\Transfer;
use app\common\sub_action\FoodCustomizedSubAction;

class FoodCustomizedAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = FoodCustomizedSubAction::index($param);
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
        $transfer = FoodCustomizedSubAction::save($param);
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
        $transfer = FoodCustomizedSubAction::read($param);
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
        $transfer = FoodCustomizedSubAction::update($param);
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
        $transfer = FoodCustomizedSubAction::delete($param);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

    /**
     * 显示资源列表
     */
    public static function feedback($param)
    {
        $transfer = FoodCustomizedSubAction::feedback($param);
        if(!$transfer->status){
            return new Transfer('添加反馈失败');
        }
        return new Transfer('', true, $transfer->data);
    }

}
