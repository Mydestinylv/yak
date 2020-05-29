<?php

namespace app\common\sub_action;

use app\common\lib\Transfer;
use app\common\model\Yaks;
use app\common\task\CustomerTask;
use app\common\task\GiftTask;
use app\common\task\YaksTask;

class GiftSubAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        $transfer = CustomerTask::valueByWhere(['id'=>$customer_id],'tel');
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        $where['yaks_birthday'] =['<',date('Y-m-d H:i:s',strtotime("-8 month"))] ;
        $where['adoption_tel'] = $transfer->data['tel'];
        $where['yaks_sex'] = 1;
        $field = 'id,id as adoption_status,yaks_name,yaks_tag,yaks_img,yaks_birthday,pasture_id as pasture_name,yaks_sex';
        $order = 'create_time desc';
        $transfer = YaksTask::paginate($where,$field,$order);
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        foreach($transfer->data['data'] as $k => $v){
            $transfer->data['data'][$k]['yaks_birthday'] = floor((strtotime(date_now())-strtotime($v['yaks_birthday']))/2592000);
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
        $transfer  = Yaks::alias('a')
            ->join('adoption_order b','a.id = b.yaks_id','LEFT')
            ->where($where)
            ->field($field)
            ->find();
        if($transfer===false){
            return new Transfer('查询失败');
        }
        $transfer['unit_price'] = 268;
        return new Transfer('', true, to_array($transfer));
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
