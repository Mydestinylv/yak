<?php

namespace app\move\action;

use app\common\lib\Transfer;
use app\common\sub_action\YaksSubAction;
use app\common\task\CustomerTask;

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
        $transfer = YaksSubAction::index($param,$where);
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

        return new Transfer('', true);
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