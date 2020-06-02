<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\SaleOrder;
use app\common\model\Yaks;
use app\common\task\CustomerTask;
use app\common\task\GiftTask;
use app\common\task\HerdsmanTask;
use app\common\task\TaskManageTask;
use app\common\task\VideoSurveillanceTask;
use app\common\task\YaksTask;

class GiftSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param, $customer_id)
    {
        $transfer = CustomerTask::valueByWhere(['id' => $customer_id], 'tel');
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        $where['yaks_birthday'] = ['<', date('Y-m-d H:i:s', strtotime("-8 month"))];
        $where['adoption_tel'] = $transfer->data['tel'];
        $where['yaks_sex'] = 1;
        $field = 'id,id as adoption_statusStr,id as adoption_id,yaks_name,yaks_tag,yaks_img,yaks_birthday,pasture_id as pasture_name,yaks_sex';
        $order = 'create_time desc';
        $transfer = YaksTask::paginate($where, $field, $order);
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        foreach ($transfer->data['data'] as $k => $v) {
            $transfer->data['data'][$k]['yaks_birthday'] = floor((strtotime(date_now()) - strtotime($v['yaks_birthday'])) / 2592000);
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
        $where['a.id'] = $param['id'];
        $field = 'a.id,a.yaks_name,a.yaks_tag,a.yaks_img,a.yaks_sex,a.yaks_birthday,a.pasture_id as pasture_name,a.herdsman_id as herdsman_name,b.pay_time,b.pay_money,b.adoption_status';
        $transfer = Yaks::alias('a')
            ->join('adoption_order b', 'a.id = b.yaks_id', 'LEFT')
            ->where($where)
            ->field($field)
            ->find();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        $transfer['unit_price'] = 268;
        $data = to_array($transfer);
        unset($where['a.id']);
        $where['a.yaks_id'] = $param['id'];
        $transfer = SaleOrder::alias('a')
            ->join('Slaughter b','a.yaks_id = b.yaks_id')
            ->where($where)
            ->field('b.final_box , sum(a.goods_number) as goods_num')
            ->group('a.id')
            ->find();
        $data['num'] = $transfer['final_box'] - $transfer['goods_num'];
        return new Transfer('', true, $data);
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
    public static function share($param)
    {
        //牦牛信息
        $where['id'] = $param['yaks_id'];
        $field = 'id,yaks_name,yaks_img,yaks_tag,yaks_sex,yaks_birthday,pasture_id as pasture_name,pasture_id,herdsman_id';
        $transfer = YaksTask::find($where, $field);
        if (!$transfer->status) {
            return new Transfer('获取数据失败');
        }
        $transfer->data['yaks_birthday'] = floor((strtotime(date_now()) - strtotime($transfer->data['yaks_birthday'])) / 2592000);
        $data['yaks_data'] = $transfer->data;
        //监控信息
        $where['id'] = $transfer->data['pasture_id'];
        $field = 'id,viewing_address';
        $transfer = VideoSurveillanceTask::find($where, $field);
        if (!$transfer->status) {
            return new Transfer('获取数据失败');
        }
        $data['video_surveillance'] = $transfer->data;
        //牧民信息
        $where['id'] = $data['yaks_data']['herdsman_id'];
        $field = 'id,introduce,healthy';
        $transfer = HerdsmanTask::find($where, $field);
        if (!$transfer->status) {
            return new Transfer('获取数据失败');
        }
        $data['herdsman_data'] = $transfer->data;
        //获取生长情况
        $where['pasture_id'] = $data['yaks_data']['pasture_id'];
        $field = 'id,task_name,enclosure_url';
        $transfer = TaskManageTask::select($where, $field, 'create_time asc');
        if (!$transfer->status) {
            return new Transfer('查询失败');
        }
        $data['task_data'] = $transfer->data;
        return new Transfer('', true, $data);
    }
}
