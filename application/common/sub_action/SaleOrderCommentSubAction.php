<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\SaleOrderComment;
use app\common\task\SaleOrderCommentTask;

class SaleOrderCommentSubAction
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
        if (isset($param['herdsman_name']) && !empty($param['herdsman_name'])) {
            $where['d.name'] = ['like', '%' . $param['herdsman_name'] . '%'];
        }
        $field = ['a.id,a.score,a.comment_content,a.create_time,b.real_name,b.tel,c.yaks_name,c.yaks_tag,d.name as herdsman_name,d.tel as herdsman_tel,a.sale_order_code'];
        $order = ['a.create_time'];
        $transfer = SaleOrderComment::alias('a')
            ->join('Customer b', 'a.customer_id = b.id', 'LEFT')
            ->join('Yaks c', 'a.yaks_id = c.id', 'LEFT')
            ->join('Herdsman d', 'a.herdsman_id = d.id', 'LEFT')
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
        $field = ['a.id,a.score,a.comment_content,a.create_time,b.real_name,b.tel,c.yaks_name,c.yaks_tag,d.name as herdsman_name,d.tel as herdsman_tel,a.sale_order_code'];
        $order = ['a.create_time'];
        $transfer = SaleOrderComment::alias('a')
            ->join('Customer b', 'a.customer_id = b.id', 'LEFT')
            ->join('Yaks c', 'a.yaks_id = c.id', 'LEFT')
            ->join('Herdsman d', 'a.herdsman_id = d.id', 'LEFT')
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
        $transfer = SaleOrderCommentTask::update($param,$where);
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
        $transfer = SaleOrderCommentTask::delete($param['id']);
        if(!$transfer->status){
            return new Transfer('删除失败');
        }
        return new Transfer('', true);
    }
}
