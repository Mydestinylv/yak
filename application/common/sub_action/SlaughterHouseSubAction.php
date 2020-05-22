<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\SlaughterHouseTask;

class SlaughterHouseSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['slaughter_house_name']) && !empty($param['slaughter_house_name'])) {
            $where['slaughter_house_name'] = ['like', '%' . $param['slaughter_house_name'] . '%'];
        }
        $field = ['id,slaughter_house_name,slaughter_house_tel,slaughter_house_cover,slaughter_house_address,slaughter_house_introduce,create_time'];
        $transfer = SlaughterHouseTask::paginate($where,$field);
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param)
    {
        $param['slaughter_house_cover'] = img_upload($param['slaughter_house_cover']);
        $transfer = SlaughterHouseTask::save($param);
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
        $where['id'] = $param['id'];
        $field = ['id,slaughter_house_name,slaughter_house_tel,slaughter_house_cover,slaughter_house_address,slaughter_house_introduce,create_time'];
        $transfer = SlaughterHouseTask::paginate($where,$field);
        if ($transfer === false) {
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
        $param['slaughter_house_cover'] = img_upload($param['slaughter_house_cover']);
        $transfer = SlaughterHouseTask::update($param,$where);
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
        $transfer = SlaughterHouseTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
