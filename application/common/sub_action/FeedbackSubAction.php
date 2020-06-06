<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\CustomerTask;
use app\common\task\FeedbackTask;
use app\common\task\HerdsmanTask;
use app\common\task\SlaughterManTask;

class FeedbackSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['description']) && !empty($param['description'])) {
            $where['description'] = ['like', '%' . $param['description'] . '%'];
        }
        if (isset($param['real_name']) && !empty($param['real_name'])) {
            $where['real_name'] = ['like', '%' . $param['real_name'] . '%'];
        }
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['tel'] = ['like', '%' . $param['tel'] . '%'];
        }
        if (isset($param['customer_type']) && !empty($param['customer_type'])) {
            $where['customer_type'] = ['like',$param['customer_type']];
        }
        if (isset($param['feedback_status']) && !empty($param['feedback_status'])) {
            $where['feedback_status'] = ['like',$param['feedback_status']];
        }
        $filed = 'id,description,enclosure,feedback_status,create_time,name,tel,user_type';
        $order = 'create_time desc';
        $transfer = FeedbackTask::paginate( $where, $filed, $order);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, $transfer->data);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param,$where,$type)
    {
        switch ($type){
            case 1 :
                $transfer = CustomerTask::find($where,'real_name as name,tel');
                break;
            case 2 :
                $transfer = HerdsmanTask::find($where,'name,tel');


                break;
            case 3 :
                $transfer = SlaughterManTask::find($where,'name,tel');

                break;
            default :
                return new Transfer('保存失败');
        }
        if(!$transfer->status){
            return new Transfer('保存失败');
        }
        unset($param['move_id']);
        unset($param['type']);
        $param['name'] = $transfer->data['name'];
        $param['tel'] = $transfer->data['tel'];
        $param['user_type'] = $type;
        $param['feedback_status'] = 1;
        $transfer = FeedbackTask::save($param);
        if (!$transfer->status) {
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
        $filed = 'id,description,enclosure,feedback_status,create_time,name,tel,user_type';
        $order = 'create_time desc';
        $transfer = FeedbackTask::find($where, $filed, $order);
        if (!$transfer->status) {
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
        $transfer = FeedbackTask::update($param,$where);
        if (!$transfer->status) {
            return new Transfer('更新失败');
        }
        return new Transfer('', true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {
        $transfer = FeedbackTask::delete($param);
        if (!$transfer->status) {
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
