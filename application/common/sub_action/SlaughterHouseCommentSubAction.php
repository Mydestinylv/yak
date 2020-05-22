<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\SlaughterHouseComment;
use app\common\task\SlaughterHouseCommentTask;

class SlaughterHouseCommentSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {
        $where = [];
        if (isset($param['comment_content']) && !empty($param['comment_content'])) {
            $where['a.comment_content'] = ['like', '%' . $param['comment_content'] . '%'];
        }
        if (isset($param['yaks_tag']) && !empty($param['yaks_tag'])) {
            $where['c.yaks_tag'] = ['like', '%' . $param['yaks_tag'] . '%'];
        }
        if (isset($param['tel']) && !empty($param['tel'])) {
            $where['b.tel'] = ['like', '%' . $param['tel'] . '%'];
        }
//        if (isset($param['herdsman_name']) && !empty($param['herdsman_name'])) {
//            $where['d.herdsman_name'] = ['like', '%' . $param['herdsman_name'] . '%'];
//        }
        $field = ['a.id,a.score,a.comment_content,a.create_time,b.real_name,b.tel,c.yaks_name,c.yaks_tag,d.slaughter_house_name'];
        $order = ['a.create_time'];
        $transfer = SlaughterHouseComment::alias('a')
            ->join('Customer b', 'a.customer_id = b.id', 'LEFT')
            ->join('Yaks c', 'a.yaks_id = c.id', 'LEFT')
            ->join('SlaughterHouse d', 'a.slaughter_house_id = d.id', 'LEFT')
            ->field($field)
            ->where($where)
            ->order($order)
            ->paginate();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, to_array($transfer));
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
        $where['a.id'] = $param['id'];
        $field = ['a.id,a.score,a.comment_content,a.create_time,b.real_name,b.tel,c.yaks_name,c.yaks_tag,d.slaughter_house_name'];
        $order = ['a.create_time'];
        $transfer = SlaughterHouseComment::alias('a')
            ->join('Customer b', 'a.customer_id = b.id', 'LEFT')
            ->join('Yaks c', 'a.yaks_id = c.id', 'LEFT')
            ->join('SlaughterHouse d', 'a.slaughter_house_id = d.id', 'LEFT')
            ->field($field)
            ->where($where)
            ->order($order)
            ->find();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        return new Transfer('', true, to_array($transfer));
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {
        $where['id'] = $param['id'];
        unset($param['id']);
        $transfer = SlaughterHouseCommentTask::update($param,$where);
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
        $transfer = SlaughterHouseCommentTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
