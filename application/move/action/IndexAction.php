<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\IndexSubAction;

class IndexAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $transfer = IndexSubAction::index($param);
        if(!$transfer->status){
            return new Transfer('获取首页失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $transfer = IndexSubAction::save($param);
        if(!$transfer->status){
            return new Transfer('获取首页失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 显示指定的资源
     */
    public static function read($param)
    {
        $transfer = IndexSubAction::index($param);
        if(!$transfer->status){
            return new Transfer('获取首页失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $transfer = IndexSubAction::index($param);
        if(!$transfer->status){
            return new Transfer('获取首页失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = IndexSubAction::index($param);
        if(!$transfer->status){
            return new Transfer('获取首页失败');
        }
        return new Transfer('', true, $transfer->data);
    }

}
