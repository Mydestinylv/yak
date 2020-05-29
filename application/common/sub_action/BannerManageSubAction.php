<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\BannerManageTask;

class BannerManageSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        $field = ['id,picture,jump_address,is_index'];
        $order = 'create_time';
        $transfer = BannerManageTask::paginate($where,$field,$order);
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
        $where['is_index'] = 1;
        if($param['is_index']==1){
            $data['is_index'] = 0;
            $transfer = BannerManageTask::update($data,$where);
            if(!$transfer->status){
                return new Transfer('保存失败');
            }
        }
        $transfer = BannerManageTask::save($param);
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
        unset($param['id']);
        $field = ['id,picture,jump_address,is_index'];
        $order = 'create_time';
        $transfer = BannerManageTask::find($where,$field,$order);
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
        $where['is_index'] = 1;
        if($param['is_index']==1){
            $data['is_index'] = 0;
            $transfer = BannerManageTask::update($data,$where);
            if(!$transfer->status){
                return new Transfer('保存失败');
            }
        }
        $where['id'] = $param['id'];
        unset($param['id']);
        unset($where['is_index']);
        $transfer = BannerManageTask::update($param,$where);
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
        $transfer = BannerManageTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
