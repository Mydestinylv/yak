<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\task\HerdsmanCommentTask;
use app\common\task\SaleOrderCommentTask;
use app\common\task\SlaughterHouseCommentTask;
use app\common\task\SlaughterTask;

class CommentSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param)
    {

        return new Transfer('', true);
    }

    /**
     * 保存新建的资源
     */
    public static function save($param,$customer_id)
    {
        $param['customer_id'] = $customer_id;
        switch ($param['comment_type']){
            case 1:
                unset($param['comment_type']);
                $where['customer_id'] = $customer_id;
                $where['herdsman_id'] = $param['herdsman_id'];
                $transfer = HerdsmanCommentTask::count($where);
                if(!$transfer->status){
                    return new Transfer('评论失败');
                }
                if($transfer->data['count']){
                    return new Transfer('你已经评论过此牧民');
                }
                $transfer = HerdsmanCommentTask::save($param);
                if(!$transfer->status){
                    return new Transfer('评论失败');
                }
                break;
            case 2:
                unset($param['comment_type']);
                $where['customer_id'] = $customer_id;
                $where['slaughter_house_id'] = $param['herdsman_id'];
                $transfer = SlaughterHouseCommentTask::count($where);
                if(!$transfer->status){
                    return new Transfer('评论失败');
                }
                if($transfer->data['count']){
                    return new Transfer('你已经评论过此屠宰场');
                }
                $transfer = SlaughterHouseCommentTask::save($param);
                if(!$transfer->status){
                    return new Transfer('评论失败');
                }
                break;
            case 3:
                unset($param['comment_type']);
                $where['customer_id'] = $customer_id;
                $where['sale_order_code'] = $param['herdsman_id'];
                $transfer = SaleOrderCommentTask::count($where);
                if(!$transfer->status){
                    return new Transfer('评论失败');
                }
                if($transfer->data['count']){
                    return new Transfer('你已经评论过此订单');
                }
                $transfer = SaleOrderCommentTask::save($param);
                if(!$transfer->status){
                    return new Transfer('评论失败');
                }
                break;
            default:
                return new Transfer('参数错误');
        }
        return new Transfer('', true, $transfer->data);
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
