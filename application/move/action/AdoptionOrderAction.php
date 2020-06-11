<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\AdoptionOrder;
use app\common\sub_action\AdoptionOrderSubAction;
use app\common\sub_action\SlaughterSubAction;
use app\common\task\AdoptionOrderTask;
use app\common\task\SlaughterRecordTask;
use app\common\task\SlaughterTask;
use think\Db;

class AdoptionOrderAction
{
    /**
     * 显示资源列表
     */
    public static function index($param, $customer_id)
    {
        $where['a.customer_id'] = $customer_id;
        $field = 'a.id,a.adoption_status,a.create_time,b.yaks_name';
        $transfer = AdoptionOrder::alias('a')
            ->join('Yaks b', 'a.yaks_id = b.id', 'LEFT')
            ->where($where)
            ->field($field)
            ->paginate($param);
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        $data = to_array($transfer);
        return new Transfer('', true, $data);
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
        $field = 'a.id,b.yaks_name,b.yaks_tag,b.yaks_birthday,b.yaks_sex,yaks_img,b.herdsman_id as herdsman_name,b.pasture_id as pasture_name,a.create_time,a.pay_money,a.yaks_id,a.adoption_status';
        $transfer = AdoptionOrder::alias('a')
            ->join('Yaks b', 'a.yaks_id = b.id', 'LEFT')
            ->where($where)
            ->field($field)
            ->find();
        if ($transfer === false) {
            return new Transfer('查询失败');
        }
        $data = to_array($transfer);
        $data['yaks_birthday'] = floor((strtotime(date_now()) - strtotime($data['yaks_birthday'])) / 2592000);
        if ($data['yaks_birthday'] >= 8&&$data['yaks_sex']==0) {
            $data['is_slaughter'] = 1;
        } else {
            $data['is_slaughter'] = 0;
        }
        if($data['adoption_status'] == '屠宰完毕'){
            $transfer = SlaughterTask::valueByWhere(['yaks_id'=>$data['yaks_id']],'final_box');
            if(!$transfer->status||empty($transfer->data['final_box'])){
                $data['final_box'] = 0;
            }else{
                $data['final_box'] = $transfer->data['final_box'];
            }
        }
        return new Transfer('', true, $data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param)
    {




        Db::startTrans();
        $where['id'] = $param['id'];
        $data['slaughter_house_id'] = $param['slaughter_house_id'];
        $data['yaks_id'] = $param['yaks_id'];
        $param['adoption_status'] = 2;
        unset($param['id']);
        unset($param['yaks_id']);
        unset($param['slaughter_house_id']);
        $transfer = AdoptionOrderTask::update($param,$where);
        if(!$transfer->status){
            Db::rollback();
            return new Transfer('更新失败');
        }
        $data['incoming_time'] = date_now();
        $transfer = SlaughterTask::valueByWhere(['yaks_id'=>$data['yaks_id']],'id');
        if(!$transfer->status){
            return new Transfer('更新失败');
        }
        if($transfer->data['id']){
            return new Transfer('此牦牛已经送到屠宰场');
        }
        $transfer = SlaughterTask::save($data);
        if(!$transfer->status){
            Db::rollback();
            return new Transfer('更新失败');
        }
        Db::commit();
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
