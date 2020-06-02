<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\AdoptionOrder;
use app\common\model\Slaughter;
use app\common\task\AdoptionOrderTask;
use app\common\task\SlaughterRecordTask;
use app\common\task\SlaughterTask;
use think\Db;

class SlaughterHouseAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$slaughter_man_id)
    {
        $where['a.status'] = 0;
        $where['c.yaks_sex'] = 1;
        $where['a.slaughter_man_id'] = $slaughter_man_id;
        if($param['status']==1){
            $where['a.status'] = 0;
        }elseif ($param['status']==2){
            $where['a.status'] = ['not in',[0,9,10]];
        }else{
            $where['a.status'] = ['in',[9,10]];
        }
        $field = 'a.id,b.slaughter_house_name,c.yaks_name,c.yaks_tag,a.status,c.yaks_img,c.yaks_birthday,d.pasture_name,c.yaks_sex,c.id as yaks_id';
        $transfer = Slaughter::alias('a')
            ->join('Slaughter_house b', 'a.slaughter_house_id = b.id', 'LEFT')
            ->join('Yaks c', 'a.yaks_id = c.id', 'LEFT')
            ->join('Pasture d', 'c.pasture_id = d.id', 'LEFT')
            ->where($where)
            ->field($field)
            ->paginate();
        $data = to_array($transfer);
        foreach ($data['data'] as $k => $v){
            $data['data'][$k]['yaks_birthday'] = floor((strtotime(date_now()) - strtotime($v['yaks_birthday'])) / 2592000);
        }
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
        //屠宰信息
        $where['a.id'] = $param['id'];
        $field = 'a.id,b.yaks_name,b.yaks_tag,b.yaks_birthday,b.pasture_id as pasture_name,a.create_time,b.yaks_img,b.yaks_sex,b.id as yaks_id,a.status,b.id as yaks_id';
        $transfer = Slaughter::alias('a')
            ->join('Yaks b','a.yaks_id = b.id','LEFT')
            ->where($where)
            ->field($field)
            ->find();
        if($transfer===false){
            return new Transfer('查询失败');
        }
        $data['yaks_info'] = to_array($transfer);
        $data['yaks_info']['yaks_birthday'] = floor((strtotime(date_now()) - strtotime($data['yaks_info']['yaks_birthday'])) / 2592000);
        unset($where['a.id']);
        //客户信息
        $where['a.yaks_id'] = $data['yaks_info']['yaks_id'];
        $field = 'b.real_name,b.tel';
        $transfer = AdoptionOrder::alias('a')
            ->join('customer b','a.customer_id = b.id','LEFT')
            ->where($where)
            ->field($field)
            ->find();
        if($transfer===false){
            return new Transfer('查询失败');
        }
        $data['customer_info'] = to_array($transfer);
        unset($where['a.yaks_id']);
        //屠宰记录信息
        $where['slaughter_id'] = $param['id'];
        $transfer = SlaughterRecordTask::select($where,'slaughter_status as status,create_time');
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        $data['slaughter_record'] = $transfer->data;


        return new Transfer('', true, $data);
    }

    /**
     * 保存更新的资源
     */
    public static function update($param,$slaughter_man_id)
    {
        Db::startTrans();
        $where['yaks_id'] = $param['yaks_id'];
        //接收更新认养订单状态
        if(!$param['status']){
            $transfer = AdoptionOrderTask::update(['adoption_status'=>3],$where);
            if(!$transfer->status){
                Db::rollback();
                return new Transfer('更新失败');
            }
        }
        $data['status'] = $param['status']+1;
        $data['slaughter_man_id'] = $slaughter_man_id;
        //更新屠宰状态
        if($data['status']==9){
            $data['final_box'] = $param['final_box'];
        }elseif($data['status']==10){
            $data['completion_time'] = date_now();
        }
        $transfer = SlaughterTask::update($data,$where);
        if(!$transfer->status){
            Db::rollback();
            return new Transfer('更新失败');
        }
        //获取屠宰ID
        $transfer = SlaughterTask::valueByWhere($where,'id');
        if(!$transfer->status){
            Db::rollback();
            return new Transfer('更新失败');
        }
        $record_data['slaughter_id'] = $transfer->data['id'];
        $record_data['slaughter_status'] = $data['status'];
        $transfer = SlaughterRecordTask::save($record_data);
        if(!$transfer->status){
            Db::rollback();
            return new Transfer('更新失败');
        }
        Db::commit();
        return new Transfer('',true);
    }

    /**
     * 删除指定资源
     */
    public static function delete($param)
    {

        return new Transfer('', true);
    }

}
