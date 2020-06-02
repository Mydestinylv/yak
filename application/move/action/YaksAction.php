<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\model\Yaks;
use app\common\sub_action\YaksSubAction;
use app\common\task\CustomerTask;
use app\common\task\HerdsmanTask;
use app\common\task\TaskManageTask;
use app\common\task\VideoSurveillanceTask;
use app\common\task\YaksTask;

class YaksAction
{
    /**
     * 显示资源列表
     */
    public static function index($param,$customer_id)
    {
        if(isset($param['yaks_sex'])&&$param['yaks_sex']!==''){
            $where['a.yaks_sex'] = $param['yaks_sex'];
        }else{
            $where['a.yaks_sex'] = 1;
        }
        $transfer = CustomerTask::valueByWhere(['id'=>$customer_id],'tel');
        if(!$transfer->status){
            return new Transfer('查询失败');
        }
        $where['a.adoption_tel'] = $transfer->data['tel'];
        $field = 'a.id,a.yaks_name,a.yaks_tag,a.yaks_birthday,b.pasture_name';
        $transfer = Yaks::alias('a')
        ->join('pasture b','a.pasture_id = b.id','LEFT')
        ->where($where)
        ->field($field)
        ->paginate();
        if($transfer===false){
            return new Transfer('查询失败');
        }
        $data = to_array($transfer);
        foreach($data['data'] as $k => $v){
            $data['data'][$k]['yaks_birthday'] = floor((strtotime(date_now())-strtotime($v['yaks_birthday']))/2592000);
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
        $where['id'] = $param['yaks_id'];
        $field = 'id,pasture_id,herdsman_id,pasture_id as pasture_name,herdsman_id as herdsman_name,yaks_name,yaks_tag,yaks_birthday,yaks_img,yaks_sex,remarks';
        $transfer = YaksTask::find($where,$field);
        if(!$transfer->status){
            return new Transfer('获取牦牛详情失败');
        }
        if($transfer->data){
            $transfer->data['yaks_birthday'] = floor((strtotime(date_now())-strtotime($transfer->data['yaks_birthday']))/2592000);
        }
        $data['yaks_info'] = $transfer->data;
        unset($where['id']);
        //监控视频
        $where['pasture_id'] = $data['yaks_info']['pasture_id'];
        $field = 'id,viewing_address';
        $transfer = VideoSurveillanceTask::select($where,$field);
        if(!$transfer->status){
            return new Transfer('获取牧场监控视频失败');
        }
        $data['pasture_video'] = to_array($transfer->data);
        unset($where['pasture_id']);
        //牧民信息
        $where['id'] = $data['yaks_info']['herdsman_id'];
        $field = 'id,introduce';
        $transfer = HerdsmanTask::find($where,$field);
        if(!$transfer->status){
            return new  Transfer('获取牧民信息失败');
        }
        $data['herdsman_info'] = $transfer->data;
        //生长信息
        unset($where['id']);
        $where = [
            'pasture_id'    =>  $data['yaks_info']['pasture_id'],
            'status'    =>  2,
        ];
        $field = 'id,task_name,enclosure_url';
        $order = 'order asc';
        $transfer = TaskManageTask::select($where,$field,$order);
        if(!$transfer->status){
            return new Transfer('获取生长信息失败');
        }
        $data['grow_info'] = $transfer->data;
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
    public static function delete($param)
    {

        return new Transfer('', true);
    }

}
