<?php

namespace app\admin\action;

use app\common\lib\Transfer;
use app\common\sub_action\HerdsmanCommentSubAction;

class HerdsmanCommentAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = HerdsmanCommentSubAction::index($param);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true,$transfer->data);
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
        $transfer = HerdsmanCommentSubAction::read($param);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        return new Transfer('', true,$transfer->data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $transfer = HerdsmanCommentSubAction::update($param);
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
        $transfer = HerdsmanCommentSubAction::delete($param);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }

}
