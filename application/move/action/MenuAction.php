<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\MenuSubAction;
use app\common\task\MenuTask;

class MenuAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        if(isset($param['menu_type'])&&!empty($param['menu_type'])){
            $where['menu_type'] = $param['menu_type'];
        }else{
            $where['menu_type'] = 1;
        }
        $field = 'id,menu_title,menu_cover';
        $transfer = MenuTask::paginate($where,$field);
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
        $transfer = MenuSubAction::read($param);
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
