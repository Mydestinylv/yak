<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\GiftSubAction;

class GiftAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        $transfer = GiftSubAction::index($param,$customer_id);
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
        $transfer = GiftSubAction::read($param);
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
     *分享指定资源
     */
    public static function share($param)
    {
        $transfer = GiftSubAction::share($param);
        if(!$transfer->status){
            return new Transfer($transfer->message);
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     *分享签名
     */
    public static function getShareSign($param)
    {
        $transfer = getSignPackage($param['url']);
        return new Transfer('', true, $transfer);
    }

}
