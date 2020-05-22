<?php

namespace app\admin\action;

use app\common\lib\Transfer;
use app\common\sub_action\LoginSubAction;

class LoginAction
{
    /**
     * 显示资源列表
     */
    public static function login($param)
    {
        $transfer = LoginSubAction::login($param);
        if(!$transfer->status){
            return new Transfer(''.$transfer->message);
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

        return new Transfer('', true);
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
